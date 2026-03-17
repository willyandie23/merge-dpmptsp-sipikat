<?php

namespace Database\Seeders;

use App\Models\Bidang;
use App\Models\StrukturOrganisasi;
use Illuminate\Database\Seeder;

class StrukturOrganisasiSeeder extends Seeder
{
    public function run(): void
    {
        // Pejabat utama berdasarkan gambar (is_pejabat = 1)
        $pejabats = [
            1 => [
                'name'     => 'EVIE SILVIA BABOE, ST',
                'nip'      => '19810526 200604 2 009',
                'golongan' => 'Pembina Tingkat I IV/b',
            ],
            2 => [
                'name'     => 'PATRISIA, ST',
                'nip'      => '19741212 200604 1 009',
                'golongan' => 'Pembina IV/a',
            ],
            3 => [
                'name'     => 'SETIAWAN, SH',
                'nip'      => '19860202 211101 1 001',
                'golongan' => 'Pembina IV/a',
            ],
            4 => [
                'name'     => 'EDDY PETRUSWANDIE, ST., MT',
                'nip'      => '19830912 211101 1 001',
                'golongan' => 'Penata Tingkat I III/d',
            ],
            5 => [
                'name'     => 'ASRI MELANI Br. SARAGIH, SP., M.I.P',
                'nip'      => '19831029 201001 2 009',
                'golongan' => 'Penata Tingkat I III/d',
            ],
            6 => [
                'name'     => 'SITI WALIDAH, SE',
                'nip'      => '19801212 201001 2 006',
                'golongan' => 'Penata Tingkat I III/d',
            ],
        ];

        // Jumlah staff (is_pejabat = 0) per bidang
        $staffCount = [
            1 => 0,
            2 => 19,
            3 => 4,
            4 => 4,
            5 => 4,
            6 => 4,
        ];

        $bidangs = Bidang::orderBy('position')->get();

        foreach ($bidangs as $bidang) {
            $pos = $bidang->position;

            // Skip kalau tidak terdefinisi di array pejabat
            if (! isset($pejabats[$pos])) {
                continue;
            }

            // Pejabat utama
            StrukturOrganisasi::create([
                'name'       => $pejabats[$pos]['name'],
                'nip'        => $pejabats[$pos]['nip'],
                'golongan'   => $pejabats[$pos]['golongan'],
                'image' => 'https://picsum.photos/seed/' . fake()->unique()->numberBetween(1, 100) . '/480/480',
                'is_pejabat' => 1,
                'id_bidang'  => $bidang->id,
            ]);

            // Staff dummy
            $count = $staffCount[$pos] ?? 4;
            for ($i = 1; $i <= $count; $i++) {
                StrukturOrganisasi::create([
                    'name'       => 'Nama Staff ' . $bidang->id . '-' . $i,
                    'nip'        => '1980' . str_pad($bidang->id, 2, '0', STR_PAD_LEFT) . str_pad($i, 6, '0', STR_PAD_LEFT) . ' 1 001',
                    'golongan'   => 'Penata III/c',
                    'image' => 'https://picsum.photos/seed/' . fake()->unique()->numberBetween(101, 200) . '/480/480',
                    'is_pejabat' => 0,
                    'id_bidang'  => $bidang->id,
                ]);
            }
        }
    }
}
