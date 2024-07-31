<?php

declare(strict_types=1);

namespace App\Filament\Traits;

use App\Contracts\Uploads\ImageServiceContract;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;

trait CreatableImages
{
    protected Collection $images;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $this->images = new Collection($data['images']);

        return $data;
    }

    protected function afterCreate(): void
    {
        $this->record = App::make(ImageServiceContract::class)->replaceImages(
            $this->record,
            $this->record->id,
            $this->record->getImagesPath(),
            $this->images,
        );
    }
}
