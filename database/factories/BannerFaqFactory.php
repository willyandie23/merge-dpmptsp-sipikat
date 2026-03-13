<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BannerFaq>
 */
class BannerFaqFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title'       => fake()->sentence(2),
            'description' => fake()->paragraph(2),
            'image'       => 'https://picsum.photos/seed/' . fake()->unique()->numberBetween(0, 300) . '/1920/1080',
            'is_active'   => 1,
        ];
    }
}
