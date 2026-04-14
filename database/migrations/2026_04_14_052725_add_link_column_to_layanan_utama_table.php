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
        Schema::table('layanan_utama', function (Blueprint $table) {
            $table->string('link')->nullable()->after('image');
            // Kolom link ini opsional (nullable), karena tidak semua layanan harus punya link
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('layanan_utama', function (Blueprint $table) {
            $table->dropColumn('link');
        });
    }
};