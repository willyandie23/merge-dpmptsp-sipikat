<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('survey', function (Blueprint $table) {
            // Hapus unique index lama
            $table->dropUnique('survey_year_month_unique');

            // Ubah kolom month menjadi triwulan
            $table->renameColumn('month', 'triwulan');

            // Ubah tipe data menjadi TINYINT (1-4)
            $table->tinyInteger('triwulan')->unsigned()->change();

            // Tambah unique index baru
            $table->unique(['year', 'triwulan'], 'survey_year_triwulan_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('survey', function (Blueprint $table) {
            $table->dropUnique('survey_year_triwulan_unique');

            $table->renameColumn('triwulan', 'month');
            $table->tinyInteger('month')->unsigned()->change();

            $table->unique(['year', 'month'], 'survey_year_month_unique');
        });
    }
};