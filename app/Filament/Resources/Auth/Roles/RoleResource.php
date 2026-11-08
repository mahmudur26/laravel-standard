<?php

namespace App\Filament\Resources\Auth\Roles;

use App\Filament\Resources\Auth\Roles\Pages\CreateRole;
use App\Filament\Resources\Auth\Roles\Pages\EditRole;
use App\Filament\Resources\Auth\Roles\Pages\ListRoles;
use App\Filament\Resources\Auth\Roles\Pages\ViewRole;
use App\Filament\Resources\Auth\Roles\Schemas\RoleForm;
use App\Filament\Resources\Auth\Roles\Schemas\RoleInfolist;
use App\Filament\Resources\Auth\Roles\Tables\RolesTable;
use App\Models\Auth\Role;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class RoleResource extends Resource
{
    protected static ?string $model = Role::class;
    protected static string|null|\UnitEnum $navigationGroup = 'Auth Management';
    protected static ?string $navigationLabel = "Admin Roles";
    protected static string|BackedEnum|null $navigationIcon = Heroicon::AdjustmentsHorizontal;

    public static function canAccess(): bool
    {
        return auth()->user()->can('role_view');
    }
    public static function form(Schema $schema): Schema
    {
        return RoleForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return RoleInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RolesTable::configure($table);
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
            'index' => ListRoles::route('/'),
            'create' => CreateRole::route('/create'),
            'view' => ViewRole::route('/{record}'),
            'edit' => EditRole::route('/{record}/edit'),
        ];
    }
}
