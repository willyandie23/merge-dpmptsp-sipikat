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
        Schema::create('survey', function (Blueprint $table) {
            $table->id();
            $table->year('year');
            $table->unsignedTinyInteger('month'); // 1-12
            $table->integer('jumlah_laki')->default(0);
            $table->integer('jumlah_perempuan')->default(0);

            for ($i = 1; $i <= 9; $i++) {
                $table->decimal("indikator{$i}", 8, 2)->nullable()->default(0);
            }

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survey');
    }
};
