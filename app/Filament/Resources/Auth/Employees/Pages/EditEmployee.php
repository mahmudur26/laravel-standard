<?php

namespace App\Filament\Resources\Auth\Employees\Pages;

use App\Filament\Resources\Auth\Employees\EmployeeResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditEmployee extends EditRecord
{
    protected static string $resource = EmployeeResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    protected function authorizeAccess(): void
    {
        abort_unless(auth()->user()->can('user_management_edit'), 403);
    }
    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()->authorize(auth()->user()->can('user_management_delete')),
        ];
    }
}
