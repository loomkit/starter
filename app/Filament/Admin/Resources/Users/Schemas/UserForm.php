<?php

namespace App\Filament\Admin\Resources\Users\Schemas;

use App\Models\User;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('photo_path')
                    ->avatar()
                    ->maxSize(2048)
                    ->label(__('Photo')),
                TextInput::make('name')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                DateTimePicker::make('email_verified_at'),
                TextInput::make('password')
                    ->required(fn (?User $record) => $record === null)
                    ->password()
                    ->revealable()
                    ->confirmed()
                    ->visible(fn (?User $record) => $record === null || $record->exists)
                    ->dehydrated(fn ($state) => ! empty($state))
                    ->dehydrateStateUsing(fn ($state) => empty($state) ? null : bcrypt($state)),
                TextInput::make('password_confirmation')
                    ->required(fn (?User $record) => $record === null)
                    ->password()
                    ->revealable()
                    ->visible(fn (?User $record) => $record === null || $record->exists)
                    ->dehydrated(false),
            ]);
    }
}
