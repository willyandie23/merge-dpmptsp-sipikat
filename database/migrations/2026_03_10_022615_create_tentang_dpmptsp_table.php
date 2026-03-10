<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tentang_dpmptsp', function (Blueprint $table) {
            $table->id();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->text('dasar_hukum')->nullable();
            $table->string('moto_layanan')->nullable();
            $table->text('visi')->nullable();
            $table->text('misi')->nullable();
            $table->text('maklumat_layanan')->nullable();
            $table->string('waktu_layanan')->nullable();
            $table->text('alamat')->nullable();
            $table->text('struktur_organisasi')->nullable(); // teks deskripsi, bukan fk
            $table->text('sasaran_layanan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tentang_dpmptsp');
    }
};
