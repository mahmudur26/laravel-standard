<?php

namespace App\Filament\Resources\Auth\Employees;

use App\Filament\Resources\Auth\Employees\Pages\CreateEmployee;
use App\Filament\Resources\Auth\Employees\Pages\EditEmployee;
use App\Filament\Resources\Auth\Employees\Pages\ListEmployees;
use App\Filament\Resources\Auth\Employees\Schemas\EmployeeForm;
use App\Filament\Resources\Auth\Employees\Tables\EmployeesTable;
use App\Models\Auth\Employee;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class EmployeeResource extends Resource
{
    public static function canAccess(): bool
    {
        return auth()->user()->can('user_management_view');
    }

    protected static ?string $model = User::class;
    protected static string|null|\UnitEnum $navigationGroup = 'Auth Management';
    protected static ?string $navigationLabel = "Team";
//    protected static ?int $navigationSort = 1;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::UserGroup;

    public static function form(Schema $schema): Schema
    {
        return EmployeeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EmployeesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListEmployees::route('/'),
            'create' => CreateEmployee::route('/create'),
            'edit' => EditEmployee::route('/{record}/edit'),
        ];
    }
}
