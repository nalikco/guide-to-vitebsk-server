<?php

declare(strict_types=1);

namespace App\Contracts\Uploads;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface ImageServiceContract
{
    /**
     * Replaces all images of the desired model.
     *
     * @param  Model  $imageable  The model for which images need to be replaced.
     * @param  Collection<int, string>  $images  Replaceable images. Example image: "places/qwerty.jpg"
     * @return Model Updated model.
     */
    public function replaceImages(Model $imageable, int $imageableId, string $path, Collection $images): Model;

    /**
     * Replaces an image of the desired model.
     *
     * @param  Model  $imageable  The model for which image need to be replaced.
     * @param  string  $image  Replaceable image. Example image: "places/qwerty.jpg"
     * @return Model Updated model.
     */
    public function replaceImage(Model $imageable, int $imageableId, string $path, string $image): Model;
}
