<?php

declare(strict_types=1);

namespace App\Filament\Traits;

use App\Contracts\Uploads\ImageServiceContract;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;

trait EditableImages
{
    protected Collection $images;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $record = static::getRecord();

        foreach ($record->images as $image) {
            $data['images'][] = sprintf('%s/%s.%s', $this->record->getImagesPath(), $image->name, $image->extension);
        }

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $this->images = new Collection($data['images']);

        return $data;
    }

    protected function afterSave(): void
    {
        $this->record = App::make(ImageServiceContract::class)->replaceImages(
            $this->record,
            $this->record->id,
            $this->record->getImagesPath(),
            $this->images,
        );
    }
}
