<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('investment_targets', function (Blueprint $table) {
            // Hapus kolom type yang tidak dibutuhkan lagi
            $table->dropColumn('type');

            // Pastikan year tetap unique
            $table->unique('year')->change();

            // Ubah nama index jika perlu (opsional, biar rapi)
            $table->dropIndex(['year']); 
            // Index year tetap ada, tapi unique sudah di atas
        });

        // Jika ingin lebih bersih, bisa rename tabel jadi investment_targets (sudah benar)
    }

    public function down()
    {
        Schema::table('investment_targets', function (Blueprint $table) {
            $table->string('type')->after('year')->default('TOTAL'); // atau ENUM('PMA','PMDN')
            $table->dropUnique(['year']);
            $table->index('year');
        });
    }
};