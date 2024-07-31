<?php

declare(strict_types=1);

namespace App\Filament\Resources\PlaceCategoryResource\Pages;

use App\Filament\Resources\PlaceCategoryResource;
use App\Filament\Traits\CreatableImage;
use Filament\Resources\Pages\CreateRecord;

class CreatePlaceCategory extends CreateRecord
{
    use CreatableImage;

    protected static string $resource = PlaceCategoryResource::class;
}
