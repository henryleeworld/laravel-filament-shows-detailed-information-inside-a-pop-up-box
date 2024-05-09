<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use LaraZeus\Popover\Tables\PopoverColumn;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label(__('Name'))
                    ->required(true)
                    ->maxLength(255)
                    ->placeholder(__('Name')),
                Forms\Components\TextInput::make('email')
                    ->label(__('Email'))
                    ->required(true)
                    ->placeholder(__('Email'))
                    ->email(true),
                Forms\Components\DateTimePicker::make('email_verified_at')
                    ->label(__('Email verified at')),
                Forms\Components\TextInput::make('password')
                    ->label(__('Password'))
                    ->password()
                    ->dehydrated(fn(?string $state): bool => filled($state))
                    ->required(fn(string $operation): bool => $operation === 'create')
                    ->maxLength(255),
                Forms\Components\FileUpload::make('avatar')
                    ->label(__('Avatar'))
                    ->image()
                    ->imageResizeMode('cover')
                    ->imageResizeTargetWidth('120')
                    ->imageResizeTargetHeight('120')
                    ->placeholder(__('Avatar'))
            ]);
    }

    public static function getModelLabel(): string
    {
        return __('user');
    }

    public static function getNavigationLabel(): string
    {
        return __('User');
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                PopoverColumn::make('name')
                    ->label(__('Name'))
                    ->searchable()
                    // ->trigger('click')
                    ->trigger('hover')
                    ->placement('right')
                    ->content(fn($record) => view('filament.user-card', ['record' => $record])),
                // Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('email')
                    ->label(__('Email'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('Created at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
