<?php

declare(strict_types=1);

use App\Models\Place;
use App\Models\PlaceCategory;
use App\Services\Uploads\ImageService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;

uses(RefreshDatabase::class);

it('can replace images', function () {
    $images = new Collection(['places/name.png', 'places/name.jpg']);

    $imageable = Place::factory()->create([
        'category_id' => PlaceCategory::factory()->create(),
    ]);

    $imageService = $this->app->make(ImageService::class);
    $imageService->replaceImages($imageable, $imageable->id, $imageable->getImagesPath(), $images);

    expect($imageable->images->count())->toBe(2);
});

it('can replace image', function () {
    $image = 'places/name.png';

    $imageable = PlaceCategory::factory()->create();

    $imageService = $this->app->make(ImageService::class);
    $imageService->replaceImage($imageable, $imageable->id, $imageable->getImagesPath(), $image);

    expect($imageable->image)->not()->toBeNull();
});
