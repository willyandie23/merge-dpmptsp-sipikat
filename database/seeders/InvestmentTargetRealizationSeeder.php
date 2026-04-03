<?php

namespace Database\Seeders;

use App\Models\InvestmentRealization;
use App\Models\InvestmentTarget;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class InvestmentTargetRealizationSeeder extends Seeder
{
    public function run()
    {
        // Nonaktifkan sementara ModelLog agar tidak error user_id null
        Schema::disableForeignKeyConstraints();

        InvestmentTarget::unsetEventDispatcher();
        InvestmentRealization::unsetEventDispatcher();

        $this->command->info('🔧 ModelLog dinonaktifkan sementara...');

        // ====================== HAPUS DATA LAMA ======================
        $this->command->info('🗑️ Menghapus data lama tahun 2024 - 2026...');

        InvestmentTarget::whereIn('year', [2024, 2025, 2026])->delete();
        InvestmentRealization::whereIn('year', [2024, 2025, 2026])->delete();

        // ====================== BUAT DATA BARU ======================
        $years = [2024, 2025, 2026];
        $types = ['PMA', 'PMDN'];

        $totalCreated = 0;

        foreach ($years as $year) {
            foreach (range(1, 4) as $quarter) {
                foreach ($types as $type) {

                    // Target Amount (dalam Rupiah)
                    $target = match ($year) {
                        2024 => rand(800, 2800) * 1000000000,   // Rp 0.8T - 2.8T
                        2025 => rand(1000, 3200) * 1000000000,
                        2026 => rand(1200, 3800) * 1000000000,
                        default => 1500000000000,
                    };

                    InvestmentTarget::create([
                        'year' => $year,
                        'quarter' => $quarter,
                        'type' => $type,
                        'target_amount' => $target,
                    ]);

                    // Realisasi (65% sampai 118% dari target)
                    $realized = (int) ($target * (rand(65, 118) / 100));

                    // Tenaga kerja yang terserap
                    $labor = $type === 'PMA'
                        ? rand(800, 4500)
                        : rand(400, 2800);

                    InvestmentRealization::create([
                        'year' => $year,
                        'quarter' => $quarter,
                        'type' => $type,
                        'realized_amount' => $realized,
                        'labor_absorbed' => $labor,
                    ]);

                    $totalCreated++;
                }
            }
        }

        Schema::enableForeignKeyConstraints();

        $this->command->info("✅ Berhasil membuat data Investment Target & Realization untuk tahun 2024 - 2026!");
        $this->command->info("   • Total record dibuat: {$totalCreated} baris (24 Target + 24 Realization)");
        $this->command->info("   • Tahun: 2024, 2025, 2026");
        $this->command->info("   • Setiap tahun memiliki 4 triwulan × 2 tipe (PMA & PMDN)");
    }
}
