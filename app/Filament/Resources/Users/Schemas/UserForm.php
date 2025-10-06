<?php

namespace App\Filament\Resources\Users\Schemas;

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
                TextInput::make('name')
                    ->label(__('Name'))
                    ->maxLength(255)
                    ->placeholder(__('Name'))
                    ->required(),
                TextInput::make('email')
                    ->label(__('Email'))
                    ->maxLength(255)
                    ->email()
                    ->unique(User::class, 'email', ignoreRecord: true)
                    ->placeholder(__('Email'))
                    ->required(),
                DateTimePicker::make('email_verified_at')
                    ->label(__('Email verified at')),
                TextInput::make('password')
                    ->label(__('Password'))
                    ->maxLength(255)
                    ->password()
                    ->dehydrated(fn(?string $state): bool => filled($state))
                    ->required(fn(string $operation): bool => $operation === 'create'),
                FileUpload::make('avatar')
                    ->label(__('Avatar'))
                    ->disk('public')
                    ->image()
                    ->imageResizeMode('cover')
                    ->imageResizeTargetWidth('120')
                    ->imageResizeTargetHeight('120')
                    ->placeholder(__('Avatar'))
            ]);
    }
}
