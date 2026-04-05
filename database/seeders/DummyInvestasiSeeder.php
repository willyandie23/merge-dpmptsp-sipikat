<?php

namespace Database\Seeders;

use App\Models\Kecamatan;
use App\Models\PeluangInvestasi;
use App\Models\Populasi;
use App\Models\ProdukDomestik;
use App\Models\Sektor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DummyInvestasiSeeder extends Seeder
{
    public function run()
    {
        // Nonaktifkan sementara ModelLog agar tidak error
        Schema::disableForeignKeyConstraints();

        // Matikan event logging dari trait
        \App\Models\Kecamatan::unsetEventDispatcher();
        \App\Models\Sektor::unsetEventDispatcher();
        \App\Models\Populasi::unsetEventDispatcher();
        \App\Models\ProdukDomestik::unsetEventDispatcher();
        \App\Models\PeluangInvestasi::unsetEventDispatcher();

        $this->command->info('🔧 ModelLog dinonaktifkan sementara...');

        // ====================== 1. KECAMATAN ======================
        $kecamatans = [
            ['name' => 'Balikpapan Timur'],
            ['name' => 'Balikpapan Selatan'],
            ['name' => 'Balikpapan Tengah'],
            ['name' => 'Balikpapan Utara'],
            ['name' => 'Balikpapan Barat'],
            ['name' => 'Balikpapan Kota'],
        ];

        $kecamatanIds = [];
        foreach ($kecamatans as $kec) {
            $kecamatanIds[] = Kecamatan::create($kec)->id;
        }

        // ====================== 2. SEKTOR ======================
        $sektorNames = [
            'Pertambangan & Energi',
            'Pariwisata & Hospitality',
            'Perikanan & Kelautan',
            'Manufaktur & Industri',
            'Pertanian & Agribisnis',
        ];

        $sektors = [];
        foreach ($sektorNames as $name) {
            $sektors[] = Sektor::create([
                'name' => $name,
                'kecamatan_id' => fake()->randomElement($kecamatanIds),
            ]);
        }

        // ====================== 3. POPULASI ======================
        foreach ($kecamatanIds as $kecId) {
            for ($year = 2023; $year <= 2026; $year++) {
                Populasi::create([
                    'kecamatan_id' => $kecId,
                    'year' => $year,
                    'amount' => rand(85000, 195000),
                ]);
            }
        }

        // ====================== 4. PRODUK DOMESTIK ======================
        foreach ($sektors as $sektor) {
            for ($year = 2024; $year <= 2026; $year++) {
                ProdukDomestik::create([
                    'sektor_id' => $sektor->id,
                    'year' => $year,
                    'amount' => rand(45000000000, 280000000000),
                ]);
            }
        }

        // ====================== 5. PELUANG INVESTASI ======================
        $judulPeluang = [
            "Pembangunan Hotel Bintang 4 dan Resort Pantai",
            "Pengembangan Tambang Batu Bara Ramah Lingkungan",
            "Budidaya Ikan Kerapu dan Udang Vaname Skala Besar",
            "Pabrik Pengolahan Kelapa Sawit Modern",
            "Pembangunan Kawasan Industri Kecil Menengah",
            "Wisata Bahari dan Snorkeling Center",
            "Pembangunan PLTS (Solar Power Plant) 50 MW",
            "Agrowisata dan Pertanian Vertikal Modern",
            "Pelabuhan Mini untuk Logistik Perikanan",
            "Pusat Perbelanjaan Modern dan Entertainment Center",
        ];

        foreach (range(1, 10) as $i) {
            PeluangInvestasi::create([
                'title' => $judulPeluang[$i - 1],
                'image' => null,                    // kosongkan dulu, nanti diupload manual
                'description' => "Proyek investasi potensial di Kota Balikpapan tahun 2024-2026 dengan estimasi nilai proyek Rp150 - 950 Miliar. Diharapkan menyerap tenaga kerja lokal hingga 1.500 orang.",
                'id_kecamatan' => fake()->randomElement($kecamatanIds),
                'id_sektor' => fake()->randomElement(collect($sektors)->pluck('id')->toArray()),
            ]);
        }

        Schema::enableForeignKeyConstraints();

        $this->command->info('✅ Dummy data Peluang Investasi 2024-2026 berhasil dibuat!');
        $this->command->info("   • 6 Kecamatan");
        $this->command->info("   • 5 Sektor");
        $this->command->info("   • 10 Peluang Investasi");
    }
}
