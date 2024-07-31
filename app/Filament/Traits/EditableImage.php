<?php

declare(strict_types=1);

namespace App\Filament\Traits;

use App\Contracts\Uploads\ImageServiceContract;
use Illuminate\Support\Facades\App;

trait EditableImage
{
    protected string $image;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $record = static::getRecord();

        $data['image'] = sprintf('%s/%s.%s', $record->getImagesPath(), $record->image->name, $record->image->extension);

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $this->image = $data['image'];

        return $data;
    }

    protected function afterSave(): void
    {
        $this->record = App::make(ImageServiceContract::class)->replaceImage(
            $this->record,
            $this->record->id,
            $this->record->getImagesPath(),
            $this->image,
        );
    }
}
