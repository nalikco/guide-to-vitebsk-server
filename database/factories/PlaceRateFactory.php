<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\PlaceRate;
use Illuminate\Database\Eloquent\Factories\Factory;
use Override;
use Random\RandomException;

/**
 * @extends Factory<PlaceRate>
 */
class PlaceRateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     *
     * @throws RandomException
     */
    #[Override]
    public function definition(): array
    {
        return [
            'rate' => random_int(1, 5),
        ];
    }
}
