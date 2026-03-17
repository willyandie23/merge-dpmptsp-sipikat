<?php

namespace Database\Seeders;

use App\Models\Bidang;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BidangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bidangs = [
            ['name' => 'Kepala Dinas', 'position' => 1],
            ['name' => 'Sekretaris Dinas', 'position' => 2],
            ['name' => 'Bidang Perencanaan Pengembangan Iklim & Promosi Penanaman Modal', 'position' => 3],
            ['name' => 'Bidang Pengawasan, Pengendalian, & Sistem Informasi Penanaman Modal', 'position' => 4],
            ['name' => 'Bidang Pengaduan, Advokasi & Pelaporan', 'position' => 5],
            ['name' => 'Bidang Pelayanan Terpadu Satu Pintu', 'position' => 6],
        ];

        foreach ($bidangs as $bidang) {
            Bidang::create($bidang);
        }
    }
}
