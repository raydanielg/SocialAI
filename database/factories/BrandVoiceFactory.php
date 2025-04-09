<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BrandVoice>
 */
class BrandVoiceFactory extends Factory
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
            'message' => fake()->paragraph,
            'tones' => [["text" => "Quibusdam duis ut iu"], ["text" => "Excepturi non suscip"], ["text" => "Dolore obcaecati min"]],
            'status' => 'active',
        ];
    }
}
