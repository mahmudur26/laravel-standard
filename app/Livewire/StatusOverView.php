<?php

namespace App\Livewire;

use App\Foundation\Enum\Job\JobStatus;
use App\Foundation\Enum\Job\JobType;
use App\Models\Job\Job;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatusOverView extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Count Title', 26)
                ->description('Description: ' . 23),
            Stat::make('Count Title', 3)
                ->description('Description: ' . 55),
            Stat::make('Count Title', 65)
                ->description('Description: ' . 11),
            Stat::make('Count Title', 100)
                ->description('Description: ' . 4),
        ];
    }
}
