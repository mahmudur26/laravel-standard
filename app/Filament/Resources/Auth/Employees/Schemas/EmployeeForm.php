<?php

namespace App\Filament\Resources\Auth\Employees\Schemas;

use App\Foundation\Enum\SpatieMediaCollectionName;
use App\Models\Auth\Role;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class EmployeeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Employee Information')->collapsible()->columns(1)->schema([
                    TextInput::make('name')
                        ->required()
                        ->label('Employee Name'),

                    TextInput::make('email')
                        ->required()
                        ->email()
                        ->label('Email Address'),

                    TextInput::make('employee_phone_number')
                        ->label('Employee Phone Number'),

                    SpatieMediaLibraryFileUpload::make('employee_photo')
                        ->collection('employee_photo'),
                ]),

                Select::make(name: 'role_id')
                    ->label(label: 'Role')
                    ->relationship(name: 'roles', titleAttribute: 'name')
                    ->options(Role::query()->where('guard_name', 'web')->orderBy('name')->pluck('name', 'id')->toArray())
                    ->searchable()
                    ->multiple()
                    ->required(),
            ])->columns(1);
    }
}
