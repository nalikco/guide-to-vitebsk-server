<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can see self', function () {
    $user = User::factory()->create();
    $token = $user->createToken('Web')->plainTextToken;

    $response = $this->getJson(route('user'), [
        'Authorization' => "Bearer $token",
    ]);

    $response->assertOk();
    $response->assertJson([
        'data' => [
            'id' => $user->id,
            'telegram_id' => $user->telegram_id,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'username' => $user->username,
            'language_code' => $user->language_code,
            'allows_write_to_pm' => $user->allows_write_to_pm,
            'created_at' => $user->created_at->toISOString(),
        ],
    ]);
});

it('cant see self if unauthorized', function () {
    $response = $this->getJson(route('user'), [
        'Authorization' => 'Bearer invalid',
    ]);

    $response->assertUnauthorized();
});
