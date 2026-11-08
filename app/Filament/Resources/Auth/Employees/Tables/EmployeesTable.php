<?php

namespace App\Filament\Resources\Auth\Employees\Tables;

use App\Foundation\Enum\CPCPosition;
use App\Foundation\Enum\Status;
use App\Foundation\Helper\Hash;
use App\Foundation\Helper\Mailer;
use App\Jobs\APIJob\Auth\PasswordUpdateJob;
use App\Mail\Auth\PasswordSetEmail;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextInputColumn;
use Filament\Tables\Table;

class EmployeesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label("Employee Name")
                    ->description(fn($record) => $record->employee_designation)
                    ->wrap()
                    ->searchable(),

                TextColumn::make('email')
                    ->label("Email")
                    ->searchable(),

                TextColumn::make('roles.name')
                    ->label("Role")
                    ->sortable()
                    ->badge(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ActionGroup::make([
                    EditAction::make()->authorize(auth()->user()->can('user_management_edit')),
                    Action::make('reset_password')
                        ->label('Reset Password')
                        ->authorize(auth()->user()->can('user_password_reset'))
                        ->color('success')
                        ->icon(Heroicon::ShieldExclamation)
                        ->action(function ($record) {
                            if (!$record) {
                                return Notification::make()
                                    ->title('Error with CPC official record.')
                                    ->danger()
                                    ->send();
                            }

                            if ($record->email) {
                                $record->update(['password' => $record->email]);
                            }
                            else{
                                return Notification::make()
                                    ->title('Error with password reset.')
                                    ->danger()
                                    ->send();
                            }

                            return Notification::make()
                                ->title('Password reset successfully.')
                                ->body($record->name . ' email is the new password. An email has been sent.')
                                ->success()
                                ->send();
                        }),
                ]),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
//                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
