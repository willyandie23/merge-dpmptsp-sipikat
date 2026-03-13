<?php

namespace Database\Seeders;

use App\Models\BannerFaq;
use Illuminate\Database\Seeder;

class BannerFaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BannerFaq::factory(3)->create();
    }
}
