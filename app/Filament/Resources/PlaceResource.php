<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\PlaceResource\Pages;
use App\Models\Place;
use App\Models\Upload;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PlaceResource extends Resource
{
    protected static ?string $model = Place::class;

    protected static ?string $label = 'Место';

    protected static ?string $pluralLabel = 'Места';

    protected static ?string $navigationGroup = 'Места';

    protected static ?string $navigationIcon = 'heroicon-o-building-storefront';

    #[\Override]
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('category_id')
                    ->relationship(name: 'category', titleAttribute: 'name')
                    ->label('Категория')
                    ->native(false)
                    ->searchable()
                    ->required()
                    ->preload()
                    ->createOptionForm([
                        Select::make('parent_id')
                            ->relationship(name: 'parent', titleAttribute: 'name')
                            ->label('Родительская')
                            ->native(false)
                            ->searchable()
                            ->preload(),
                        TextInput::make('name')
                            ->label('Название')
                            ->required()
                            ->string()
                            ->maxLength(255),
                        FileUpload::make('image')
                            ->label('Иконка')
                            ->image()
                            ->disk('public')
                            ->directory('place-categories')
                            ->required(),
                    ])
                    ->editOptionForm([
                        Select::make('parent_id')
                            ->relationship(name: 'parent', titleAttribute: 'name')
                            ->label('Родительская')
                            ->native(false)
                            ->searchable()
                            ->preload(),
                        TextInput::make('name')
                            ->label('Название')
                            ->required()
                            ->string()
                            ->maxLength(255),
                        FileUpload::make('image')
                            ->label('Иконка')
                            ->image()
                            ->disk('public')
                            ->directory('place-categories')
                            ->required(),
                    ]),
                TextInput::make('name')
                    ->label('Название')
                    ->required()
                    ->string()
                    ->maxLength(255),
                FileUpload::make('images')
                    ->label('Фото')
                    ->multiple()
                    ->image()
                    ->reorderable()
                    ->disk('public')
                    ->directory('places')
                    ->required()
                    ->minFiles(1)
                    ->maxFiles(5),
                RichEditor::make('description')
                    ->label('Описание')
                    ->required()
                    ->string()
                    ->maxLength(2500),
                TextInput::make('address')
                    ->label('Адрес')
                    ->required()
                    ->string()
                    ->maxLength(255),
                TextInput::make('phone_number')
                    ->label('Номер телефона')
                    ->string()
                    ->mask('+375 (99) 999-99-99')
                    ->maxLength(255),
                TextInput::make('opening_hours')
                    ->label('Время работы')
                    ->string()
                    ->maxLength(255),
                TextInput::make('instagram')
                    ->label('Instagram')
                    ->string()
                    ->prefix('https://instagram.com/')
                    ->maxLength(255),
                TextInput::make('yandex_maps')
                    ->label('Яндекс.Карты')
                    ->string()
                    ->prefix('https://yandex.by/maps/')
                    ->maxLength(255),
                Checkbox::make('active')
                    ->label('Видно всем')
                    ->required()
                    ->default(true),
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
                Tables\Columns\ImageColumn::make('images')
                    ->square()
                    ->getStateUsing(fn (Place $record) => $record->images->map(fn (Upload $image) => asset(sprintf('storage/%s/%s.%s', $record->getImagesPath(), $image->name, $image->extension)))->reverse())
                    ->label('Фото'),
                Tables\Columns\CheckboxColumn::make('active')
                    ->sortable()
                    ->label('Видно всем'),
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->label('Название'),
                Tables\Columns\TextColumn::make('created_at')
                    ->sortable()
                    ->label('Дата добавления'),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('active')
                    ->label('Видно всем')
                    ->native(false),
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
            'index' => Pages\ListPlaces::route('/'),
            'create' => Pages\CreatePlace::route('/create'),
            'edit' => Pages\EditPlace::route('/{record}/edit'),
        ];
    }
}
