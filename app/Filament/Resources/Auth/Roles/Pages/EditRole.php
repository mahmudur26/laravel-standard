<?php

namespace App\Filament\Resources\Auth\Roles\Pages;

use App\Filament\Resources\Auth\Roles\RoleResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditRole extends EditRecord
{
    protected static string $resource = RoleResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    protected function authorizeAccess(): void
    {
        abort_unless(auth()->user()->can('role_edit'), 403);
    }
    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make()->authorize(auth()->user()->can('role_view')),
            DeleteAction::make()->authorize(auth()->user()->can('role_delete')),
        ];
    }
}
