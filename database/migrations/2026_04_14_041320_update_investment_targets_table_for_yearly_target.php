<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('investment_targets', function (Blueprint $table) {
            // 1. Hapus kolom quarter (karena target sekarang per tahun saja)
            if (Schema::hasColumn('investment_targets', 'quarter')) {
                $table->dropColumn('quarter');
            }

            // 2. Hapus unique index lama yang mengandung quarter
            if (Schema::hasIndex('investment_targets', ['year', 'quarter', 'type'], 'unique')) {
                $table->dropUnique('investment_targets_year_quarter_type_unique');
            } elseif (Schema::hasIndex('investment_targets', 'investment_targets_year_quarter_type_unique')) {
                $table->dropUnique('investment_targets_year_quarter_type_unique');
            }

            // 3. Buat unique index baru (year + type saja)
            if (!Schema::hasIndex('investment_targets', ['year', 'type'], 'unique')) {
                $table->unique(['year', 'type'], 'investment_targets_year_type_unique');
            }

            // 4. Tambah index year hanya jika belum ada
            if (!Schema::hasIndex('investment_targets', ['year'])) {
                $table->index('year', 'investment_targets_year_index');
            }
        });
    }

    public function down(): void
    {
        Schema::table('investment_targets', function (Blueprint $table) {
            $table->tinyInteger('quarter')->unsigned()->after('year');

            if (Schema::hasIndex('investment_targets', ['year', 'type'], 'unique')) {
                $table->dropUnique('investment_targets_year_type_unique');
            }

            $table->unique(['year', 'quarter', 'type'], 'investment_targets_year_quarter_type_unique');
        });
    }
};