<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('investment_realizations', function (Blueprint $table) {
            // Hapus unique index lama jika ada (aman)
            if (Schema::hasIndex('investment_realizations', 'investment_realizations_year_quarter_type_unique')) {
                $table->dropUnique('investment_realizations_year_quarter_type_unique');
            }

            // Buat ulang unique index (tetap sama seperti sebelumnya)
            if (!Schema::hasIndex('investment_realizations', ['year', 'quarter', 'type'], 'unique')) {
                $table->unique(['year', 'quarter', 'type'], 'investment_realizations_year_quarter_type_unique');
            }

            // Tambah index year hanya jika belum ada (ini penyebab error Duplicate key)
            if (!Schema::hasIndex('investment_realizations', ['year'])) {
                $table->index('year', 'investment_realizations_year_index');
            }
        });
    }

    public function down(): void
    {
        Schema::table('investment_realizations', function (Blueprint $table) {
            if (Schema::hasIndex('investment_realizations', 'investment_realizations_year_quarter_type_unique')) {
                $table->dropUnique('investment_realizations_year_quarter_type_unique');
            }
            // Tidak perlu drop index year di down (opsional)
        });
    }
};