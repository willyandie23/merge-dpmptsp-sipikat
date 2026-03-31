<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('investment_targets', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('year')->index();
            $table->tinyInteger('quarter')->unsigned();           // 1 = Triwulan I, 2 = II, 3 = III, 4 = IV
            $table->enum('type', ['PMA', 'PMDN']);
            $table->unsignedBigInteger('target_amount')->default(0); // Target Investasi (Rp)
            $table->timestamps();

            // Unique agar tidak ada duplikat data
            $table->unique(['year', 'quarter', 'type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('investment_targets');
    }
};
