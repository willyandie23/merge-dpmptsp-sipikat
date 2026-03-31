<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('investment_realizations', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('year')->index();
            $table->tinyInteger('quarter')->unsigned();
            $table->enum('type', ['PMA', 'PMDN']);
            $table->unsignedBigInteger('realized_amount')->default(0);   // Capaian Investasi (Rp)
            $table->unsignedInteger('labor_absorbed')->default(0);       // ← Penyerapan Tenaga Kerja (ini yang kamu butuh)
            $table->timestamps();

            // Unique agar tidak duplikat
            $table->unique(['year', 'quarter', 'type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('investment_realizations');
    }
};
