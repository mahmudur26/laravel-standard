<?php

namespace App\Http\Middleware;

use App\Models\Count\APIHitRecord;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Jenssegers\Agent\Agent;
use Symfony\Component\HttpFoundation\Response;

class ApiHitRecordMiddleware
{
    protected Agent $agent;

    public function __construct()
    {
        $this->agent = new Agent();
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $this->agent->setUserAgent($request->userAgent());
        $api_segments = explode('/', $request->path());
        $ip = $this->getIpAddress($request);
        $locations = $this->getLocation($ip);

        APIHitRecord::query()->create([
            'api_visitor_ip' => $ip,
            'api_visitor_platform' => $this->agent->platform() ?: null,
            'api_visitor_browser_name' => $this->agent->browser() ?: null,
            'api_visitor_browser_version' =>  $this->agent->browser() ? $this->agent->version($this->agent->browser()) : null,
            'api_visitor_os_type' => $this->agent->platform() ?: null,
            'api_version' => $api_segments[2] ?? null,
            'api_path' => $api_segments[1] ?? null,
            'api_visitor_device_type' => $this->getDeviceType(),
            'api_visitor_device_brand' => $this->agent->device(),
            'api_visitor_device_model' => $this->agent->device() ? $this->parseDeviceModel($request->userAgent()) : null,
            'api_visitor_location_latitude' => $locations['location_lat'] ?? NULL,
            'api_visitor_location_longitude' => $locations['location_lng'] ?? NULL,
            'api_visitor_location_city' => $locations['location_city'] ?? NULL,
            'api_visitor_location_country' => $locations['location_country'] ?? NULL,
            'api_visit_time' => Carbon::now(),
        ]);

        return $next($request);
    }

    protected function getDeviceType(): string
    {
        if ($this->agent->isDesktop()) return 'Desktop';
        if ($this->agent->isTablet()) return 'Tablet';
        if ($this->agent->isMobile()) return 'Mobile';
        if ($this->agent->isRobot()) return 'Bot';

        return 'Unknown';
    }

    protected function getIpAddress(Request $request): ?string
    {
        // Check for proxy headers first
        $ip = $request->header('X-Forwarded-For')
            ?? $request->header('X-Real-IP')
            ?? $request->ip();

        // Get first IP if multiple (X-Forwarded-For can be comma-separated)
        if (str_contains($ip, ',')) {
            $ip = trim(explode(',', $ip)[0]);
        }

        return filter_var($ip, FILTER_VALIDATE_IP) ? $ip : null;
    }

    protected function parseDeviceModel(?string $userAgent): ?string
    {
        if (!$userAgent) return null;

        // Extract model from common patterns
        // iPhone
        if (preg_match('/iPhone\s?(?:OS)?\s?([\d_]+)?.*?(?:\(([^)]+)\))?/', $userAgent, $matches)) {
            return 'iPhone';
        }

        // iPad
        if (preg_match('/iPad.*?\(([^)]+)\)/', $userAgent)) {
            return 'iPad';
        }

        // Android device
        if (preg_match('/Android.*?;\s*([^;]+)\s*Build/', $userAgent, $matches)) {
            return trim($matches[1]);
        }

        return null;
    }

    public function getLocation(?string $ip): array
    {
        // Skip for missing or local/private IPs
        if (!$ip || $this->isPrivateIp($ip)) {
            return [];
        }

        try {
            // Using ip-api.com (free, no key required for non-commercial)
            $response = Http::timeout(5)->get("http://ip-api.com/json/{$ip}?fields=status,country,countryCode,city,lat,lon,query");

            if ($response->successful() && $response->json('status') === 'success') {
                return [
                    'location_country' => $response->json('countryCode'),
                    'location_city' => $response->json('city'),
                    'location_lat' => $response->json('lat'),
                    'location_lng' => $response->json('lon'),
                ];
            }
        } catch (\Exception $e) {
            \Log::warning("IP geolocation failed for {$ip}: " . $e->getMessage());
        }

        return [];
    }

    protected function isPrivateIp(string $ip): bool
    {
        return !filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE);
    }
}
