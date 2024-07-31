<?php

declare(strict_types=1);

namespace App\Filament\Resources\PlaceCategoryResource\Pages;

use App\Filament\Resources\PlaceCategoryResource;
use App\Filament\Traits\EditableImage;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Override;

class EditPlaceCategory extends EditRecord
{
    use EditableImage;

    protected static string $resource = PlaceCategoryResource::class;

    #[Override]
    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
