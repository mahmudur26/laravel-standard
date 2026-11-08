<?php

namespace App\Livewire;

use App\Models\Count\APIHitRecord;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class YearlyCountChart extends ChartWidget
{
    protected ?string $heading = 'Weekly count in last 365 days';
    protected int | string | array $columnSpan = 2;
    protected static ?int $sort = 3;
    protected ?string $maxHeight = '300px';
    protected function getType(): string
    {
        return 'bar';
    }
    protected function getData(): array
    {
        $data = Trend::model(APIHitRecord::class)
            ->dateColumn('api_visit_time')
            ->between(
                start: now()->subDay(365),
                end: now(),
            )
            ->perWeek()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Count',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                    'borderColor' => '#f19c79',
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }


}
