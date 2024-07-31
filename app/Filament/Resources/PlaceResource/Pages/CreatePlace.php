<?php

declare(strict_types=1);

namespace App\Filament\Resources\PlaceResource\Pages;

use App\Filament\Resources\PlaceResource;
use App\Filament\Traits\CreatableImages;
use Filament\Resources\Pages\CreateRecord;

class CreatePlace extends CreateRecord
{
    use CreatableImages;

    protected static string $resource = PlaceResource::class;
}
