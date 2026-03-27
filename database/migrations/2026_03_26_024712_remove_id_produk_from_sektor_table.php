<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('sektor', function (Blueprint $table) {
            // Hapus foreign key constraint terlebih dahulu
            $table->dropForeign(['id_produk']);                    // Laravel otomatis mencari nama constraint
            // Alternatif jika di atas error, gunakan nama exact:
            // $table->dropForeign('sektor_id_produk_foreign');

            // Baru hapus kolomnya
            $table->dropColumn('id_produk');
        });
    }

    public function down()
    {
        Schema::table('sektor', function (Blueprint $table) {
            // Rollback: tambahkan kembali kolom + foreign key
            $table->unsignedBigInteger('id_produk')->nullable();

            $table->foreign('id_produk')
                ->references('id')
                ->on('produk_domestik')
                ->onDelete('set null');
        });
    }
};
