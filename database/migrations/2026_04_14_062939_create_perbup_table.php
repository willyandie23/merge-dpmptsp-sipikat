<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('perbup', function (Blueprint $table) {
            $table->id();
            $table->text('teks_perbup');           // Teks utama Peraturan Bupati
            $table->boolean('is_active')->default(true);  // Untuk mengaktifkan/nonaktifkan tampilan
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('perbup');
    }
};