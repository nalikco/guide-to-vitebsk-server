<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Place;
use Illuminate\Database\Eloquent\Factories\Factory;
use Override;

/**
 * @extends Factory<Place>
 */
class PlaceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    #[Override]
    public function definition(): array
    {
        return [
            'name' => $this->faker->words(asText: true),
            'description' => $this->faker->text(500),
            'address' => $this->faker->address(),
            'phone_number' => $this->faker->phoneNumber(),
            'opening_hours' => 'пн-вс, 09:00-22:00',
            'instagram' => $this->faker->url(),
            'yandex_maps' => $this->faker->url(),
        ];
    }
}
