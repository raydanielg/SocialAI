<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BrandAudience>
 */
class BrandAudienceFactory extends Factory
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
            'segments' => [
                ['text' => fake()->sentence],
                ['text' => fake()->sentence],
                ['text' => fake()->sentence],
            ],
            'status' => fake()->randomElement(['active']),
        ];
    }
}
