<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('perizinan_terbit', function (Blueprint $table) {
            // Rename kolom month menjadi triwulan
            $table->renameColumn('month', 'triwulan');

            // Ubah tipe data menjadi TINYINT (lebih sesuai untuk triwulan 1-4)
            $table->tinyInteger('triwulan')->unsigned()->change();

            // Tambahkan unique constraint baru (year + triwulan)
            $table->unique(['year', 'triwulan']);
        });
    }

    public function down(): void
    {
        Schema::table('perizinan_terbit', function (Blueprint $table) {
            // Hapus unique constraint
            $table->dropUnique(['year', 'triwulan']);

            // Kembalikan nama kolom dan tipe data
            $table->renameColumn('triwulan', 'month');
            $table->tinyInteger('month')->unsigned()->change();
        });
    }
};