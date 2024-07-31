<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\PlaceCategoryResource\Pages;
use App\Models\PlaceCategory;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PlaceCategoryResource extends Resource
{
    protected static ?string $model = PlaceCategory::class;

    protected static ?string $label = 'Категория мест';

    protected static ?string $pluralLabel = 'Категории мест';

    protected static ?string $navigationGroup = 'Места';

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    #[\Override]
    public static function form(Form $form): Form
    {
        $parentCategoriesQuery = PlaceCategory::query();
        if (! is_string($form->model)) {
            $parentCategoriesQuery->whereNot('id', $form->model->id);
        }

        return $form
            ->schema([
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
                    ->getStateUsing(fn (PlaceCategory $record) => asset(sprintf('storage/%s/%s.%s', $record->getImagesPath(), $record->image->name, $record->image->extension)))
                    ->label('Иконка'),
                Tables\Columns\TextColumn::make('parent.name')
                    ->sortable()
                    ->placeholder('Нет')
                    ->label('Родительская'),
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->label('Название'),
                Tables\Columns\TextColumn::make('created_at')
                    ->sortable()
                    ->label('Дата добавления'),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Родительская')
                    ->options(PlaceCategory::all()->pluck('name', 'id'))
                    ->attribute('parent_id')
                    ->native(false)
                    ->multiple()
                    ->searchable()
                    ->preload(),
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
            'index' => Pages\ListPlaceCategories::route('/'),
            'create' => Pages\CreatePlaceCategory::route('/create'),
            'edit' => Pages\EditPlaceCategory::route('/{record}/edit'),
        ];
    }
}
