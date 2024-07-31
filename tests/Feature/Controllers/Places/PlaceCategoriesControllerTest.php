<?php

declare(strict_types=1);

use App\Models\PlaceCategory;
use App\Models\Upload;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can see categories sorted by views count', function () {
    $user = User::factory()->create();

    $firstPlaceCategory = PlaceCategory::factory()->create();
    Upload::factory()->create([
        'uploadable_id' => $firstPlaceCategory->id,
        'uploadable_type' => PlaceCategory::class,
    ]);
    $firstPlaceCategory->views()->createMany([[
        'user_id' => $user->id,
    ], [
        'user_id' => $user->id,
    ]]);
    $secondPlaceCategory = PlaceCategory::factory()->create();
    Upload::factory()->create([
        'uploadable_id' => $secondPlaceCategory->id,
        'uploadable_type' => PlaceCategory::class,
    ]);
    $secondPlaceCategory->views()->create([
        'user_id' => $user->id,
    ]);

    $thirdPlaceCategory = PlaceCategory::factory()->create();
    Upload::factory()->create([
        'uploadable_id' => $thirdPlaceCategory->id,
        'uploadable_type' => PlaceCategory::class,
    ]);

    $response = $this->actingAs($user)
        ->getJson(route('place-categories'));

    $response->assertOk();
    $response->assertJson([
        'data' => [
            [
                'id' => $firstPlaceCategory->id,
            ], [
                'id' => $secondPlaceCategory->id,
            ], [
                'id' => $thirdPlaceCategory->id,
            ],
        ],
    ]);
});

it('cant see categories if unauthorized', function () {
    $response = $this->getJson(route('place-categories'));
    $response->assertUnauthorized();
});
