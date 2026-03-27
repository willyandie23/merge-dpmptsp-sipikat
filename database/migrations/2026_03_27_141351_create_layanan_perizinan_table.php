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
        Schema::create('layanan_perizinan', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('icon');                    // contoh: mdi mdi-file-document
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('position')->default(99);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('layanan_perizinan');
    }
};
