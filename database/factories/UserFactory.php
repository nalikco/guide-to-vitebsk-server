<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Override;
use Random\RandomException;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
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
            'telegram_id' => random_int(100000, 999999),
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'username' => $this->faker->userName(),
            'language_code' => $this->faker->languageCode(),
            'allows_write_to_pm' => $this->faker->boolean(),
        ];
    }
}
