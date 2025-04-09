<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Brand>
 */
class BrandFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => fake()->numberBetween(1, 2),
            'name' => fake()->company,
            'logo' => fake()->imageUrl(),
            'slogan' => fake()->sentence,
            'color' => ['primary' => fake()->hexColor, 'secondary' => fake()->hexColor],
            'description' => fake()->paragraph,
            'identities' => [
                'mission' => fake()->sentence,
                'vision' => fake()->sentence,
                'values' => fake()->sentence,
            ],
            'audiences' => ['segments' => [
                ['text' => fake()->sentence],
                ['text' => fake()->sentence],
                ['text' => fake()->sentence],
            ]],
            'strategy' => fake()->paragraph,
            'voices' => [
                'message' => fake()->sentence,
                'tones' => [
                    ['text' => fake()->sentence],
                    ['text' => fake()->sentence],
                    ['text' => fake()->sentence],
                ],
            ],
        ];
    }
}
