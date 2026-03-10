<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class NewsFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title'       => fake()->sentence(7),
            'author'      => fake()->name(),
            'image'       => 'https://picsum.photos/seed/' . fake()->numberBetween(1, 99) . '/800/500',
            'description' => $this->generateCkEditorContent(),
            'is_active'   => 1,
        ];
    }

    private function generateCkEditorContent(): string
    {
        $faker = fake();

        return '
            <p>' . $faker->paragraph(4) . '</p>

            <h2>' . $faker->sentence(4) . '</h2>
            <p>' . $faker->paragraph(5) . '</p>

            <p>' . $faker->paragraph(3) . '</p>

            <h3>' . $faker->sentence(3) . '</h3>
            <ul>
                <li>' . $faker->sentence(6) . '</li>
                <li>' . $faker->sentence(5) . '</li>
                <li>' . $faker->sentence(7) . '</li>
                <li>' . $faker->sentence(4) . '</li>
            </ul>

            <p>' . $faker->paragraph(4) . '</p>

            <blockquote>
                <p><em>' . $faker->paragraph(2) . '</em></p>
            </blockquote>

            <p>' . $faker->paragraph(3) . '</p>

            <h3>' . $faker->sentence(3) . '</h3>
            <ol>
                <li>' . $faker->sentence(5) . '</li>
                <li>' . $faker->sentence(6) . '</li>
                <li>' . $faker->sentence(4) . '</li>
            </ol>

            <p><strong>' . $faker->sentence(5) . '</strong></p>
            <p>' . $faker->paragraph(4) . '</p>
        ';
    }
}
