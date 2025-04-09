<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BrandIdentity>
 */
class BrandIdentityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category_id' =>  fake()->randomElement([92, 93, 94]),
            'mission' => fake()->paragraph,
            'vision' => fake()->paragraph,
            'values' => fake()->paragraph,
            'status' => fake()->randomElement(['active']),
        ];
    }
}
