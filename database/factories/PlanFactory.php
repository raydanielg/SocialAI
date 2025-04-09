<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Plan>
 */
class PlanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->unique()->randomElement(['Starter', 'Enterprise', 'Basic']),
            'description' => fake()->sentence,
            'days' => fake()->randomElement([30, 365, 99999]),
            'price' => fake()->randomFloat(2, 0, 1000),
            'data' => [
                'credits' => ['value' => $credits = fake()->numberBetween(500, 1000), 'overview' => 'Credit: ' . $credits],
                'brands' => ['value' => $brands = fake()->numberBetween(5, 10), 'overview' => 'Max brands: ' . $brands],
                'social_accounts' => ['value' => $social_accounts = fake()->numberBetween(1, 10), 'overview' => 'Max Social Account: ' . $social_accounts],
                'posts' => ['value' => $posts = fake()->numberBetween(10, 50), 'overview' => 'Max create post: ' . $posts],
                'storage_size' => ['value' => $storage_size = fake()->numberBetween(1, 2), 'overview' => 'Storage limitation in GB: ' . $storage_size],

                'analytics' => ['value' => fake()->boolean, 'overview' => 'Show the analytics of brand contents'],
                'stock_library' => ['value' => fake()->boolean, 'overview' => 'Stock library access [unsplash,pixels]'],
                'scheduling' => ['value' => fake()->boolean, 'overview' => 'Allow post scheduling'],
                'image_editor' => ['value' => fake()->boolean, 'overview' => 'Image editor'],
                'stock_content' => fake()->boolean
            ],
            'is_featured' => fake()->boolean,
            'is_recommended' => fake()->boolean,
            'is_trial' => fake()->boolean,
            'status' => 1,
            'trial_days' => fake()->numberBetween(0, 30)
        ];
    }
}
