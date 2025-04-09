<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BrandSlogan>
 */
class BrandSloganFactory extends Factory
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
            'title' => fake()->paragraph(1),
            'status' => fake()->randomElement(['active']),
        ];
    }
}
