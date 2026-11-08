<?php

namespace App\Filament\Resources\Auth\Roles\Schemas;

use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Page;
use Filament\Resources\Pages\EditRecord;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Model;

class RoleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        TextInput::make('name'),

                        Select::make('guard_name')
                            ->options(collect(config('auth.guards'))->mapWithKeys(fn ($item, $index) => [$index => strtoupper($index)])->toArray())
                            ->hidden(fn (Page $livewire) => ($livewire instanceof EditRecord))
                            ->required(),

                        CheckboxList::make('permissions')
                            ->relationship('permissions', 'name', fn ($query) => $query->where('guard_name', 'web'))
                            ->getOptionLabelFromRecordUsing(fn (Model $record) => ucwords(str_replace('_', ' ', $record->name)))
                            ->bulkToggleable()
                            ->columns(4)
                            ->searchable(),
                    ])->columns(1),
            ])->columns(1);
    }
}
