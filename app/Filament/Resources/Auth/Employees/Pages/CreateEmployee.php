<?php

namespace App\Filament\Resources\Auth\Employees\Pages;

use App\Filament\Resources\Auth\Employees\EmployeeResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Hash;

class CreateEmployee extends CreateRecord
{
    protected static string $resource = EmployeeResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['password'] = Hash::make($data['email']);
        return $data;
    }
    protected function getCreatedNotificationMessage(): ?string
    {
        return "New user created. Use email address as your default password to login.";
    }
}
