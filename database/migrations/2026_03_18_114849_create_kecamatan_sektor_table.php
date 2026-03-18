<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('kecamatan_sektor', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('kecamatan_id');
            $table->unsignedBigInteger('sektor_id');

            $table->timestamps();

            // Unique agar tidak ada duplikat hubungan yang sama
            $table->unique(['kecamatan_id', 'sektor_id']);

            // Foreign keys
            $table->foreign('kecamatan_id')
                ->references('id')
                ->on('kecamatan')
                ->onDelete('cascade');

            $table->foreign('sektor_id')
                ->references('id')
                ->on('sektor')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('kecamatan_sektor');
    }
};
