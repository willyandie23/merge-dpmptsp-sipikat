<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Video>
 */
class VideoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $youtubeIds = [
            'JGwWNGJdvx8', 'kJQP7kiw5Fk', 'RgKAFK5djSk',
            'OPf0YbXqDm0', 'hT_nvWreIhg', 'YqeW9_5kURI',
            '9bZkp7q19f0', 'fJ9rUzIMcZQ', 'CevxZvSJLk8',
            'pRpeEdMmmQ0', 'dQw4w9WgXcQ', 'jNQXAC9IVRw',
            'lp-EO5I60KA', 'nfWlot6h_JM', 'TUVcZfQe-Kw',
            'djV11Xbc914', 'y6Sxv-sUYtM', '2vjPBrBU-TM',
            'H-kL8A4RNQ8', 'eVTXPUF4Oz4', 'uelHwf8o7_U',
            'SlPhMPnQ58k', 'XqZsoesa55w', '1G4isv_Fylg',
            'lAIGb1lfpBw',
        ];

        $id = fake()->unique()->randomElement($youtubeIds);

        return [
            'title'       => fake()->sentence(5),
            'description' => fake()->paragraph(2),
            'url'         => 'https://www.youtube.com/watch?v=' . $id,
            'is_active'   => 1,
        ];
    }
}
