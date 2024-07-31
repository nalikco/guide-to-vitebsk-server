<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $label = 'Telegram пользователь';

    protected static ?string $pluralLabel = 'Telegram пользователи';

    protected static ?string $navigationGroup = 'Пользователи';

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    #[\Override]
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('telegram_id')
                    ->label('Telegram ID')
                    ->required()
                    ->numeric(),
                TextInput::make('first_name')
                    ->label('Имя')
                    ->string()
                    ->maxLength(255),
                TextInput::make('last_name')
                    ->label('Фамилия')
                    ->string()
                    ->maxLength(255),
                TextInput::make('username')
                    ->label('Имя пользователя')
                    ->string()
                    ->required()
                    ->maxLength(255),
                TextInput::make('language_code')
                    ->label('Язык')
                    ->string()
                    ->required()
                    ->minLength(2)
                    ->maxLength(2),
            ]);
    }

    #[\Override]
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable()
                    ->label('ID'),
                Tables\Columns\TextColumn::make('telegram_id')
                    ->sortable()
                    ->label('Telegram ID'),
                Tables\Columns\TextColumn::make('first_name')
                    ->sortable()
                    ->label('Имя'),
                Tables\Columns\TextColumn::make('last_name')
                    ->sortable()
                    ->label('Фамилия'),
                Tables\Columns\TextColumn::make('username')
                    ->sortable()
                    ->label('Имя пользователя'),
                Tables\Columns\TextColumn::make('language_code')
                    ->sortable()
                    ->label('Язык'),
                Tables\Columns\TextColumn::make('created_at')
                    ->sortable()
                    ->label('Дата создания'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    #[\Override]
    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    #[\Override]
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
