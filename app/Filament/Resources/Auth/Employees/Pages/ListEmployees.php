<?php

namespace App\Filament\Resources\Auth\Employees\Pages;

use App\Filament\Resources\Auth\Employees\EmployeeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListEmployees extends ListRecords
{
    protected static string $resource = EmployeeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->authorize(auth()->user()->can('user_management_create')),
        ];
    }
}
