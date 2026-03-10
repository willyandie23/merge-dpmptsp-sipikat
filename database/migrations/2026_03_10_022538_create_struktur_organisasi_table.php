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
        Schema::create('struktur_organisasi', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('nip')->nullable();
            $table->string('golongan')->nullable();
            $table->string('image')->nullable();
            $table->boolean('is_pejabat')->default(false);
            $table->foreignId('id_bidang')->constrained('bidang')->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('struktur_organisasi');
    }
};
