<?php

namespace App\Livewire;

use App\Models\Count\APIHitRecord;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class SiteHitChart extends ChartWidget
{
    protected ?string $heading = 'Site hit in last 30 days';
    protected static ?int $sort = 1;
    protected function getType(): string
    {
        return 'line';
    }
    protected function getData(): array
    {
        $data = Trend::model(APIHitRecord::class)
            ->dateColumn('api_visit_time')
            ->between(
                start: now()->subDays(30),
                end: now(),
            )
            ->perDay()
            ->count();
        return [
            'datasets' => [
                [
                    'label' => 'Count',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                    'tension' => 0.4,
                    'borderColor' => '#10b981',
                    'fill' => true,
                    'backgroundColor' => 'rgba(16, 185, 129, 0.2)',
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => Carbon::parse($value->date)->format('j M')),
        ];
    }


}
