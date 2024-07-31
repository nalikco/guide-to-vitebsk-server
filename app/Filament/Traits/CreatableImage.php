<?php

declare(strict_types=1);

namespace App\Filament\Traits;

use App\Contracts\Uploads\ImageServiceContract;
use Illuminate\Support\Facades\App;

trait CreatableImage
{
    protected string $image;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $this->image = $data['image'];

        return $data;
    }

    protected function afterCreate(): void
    {
        $this->record = App::make(ImageServiceContract::class)->replaceImage(
            $this->record,
            $this->record->id,
            $this->record->getImagesPath(),
            $this->image,
        );
    }
}
