<?php

declare(strict_types=1);

namespace App\Filament\Resources\PlaceCategoryResource\Pages;

use App\Filament\Resources\PlaceCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPlaceCategories extends ListRecords
{
    protected static string $resource = PlaceCategoryResource::class;

    #[\Override]
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
