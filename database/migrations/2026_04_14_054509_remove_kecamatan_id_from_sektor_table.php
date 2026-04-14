<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sektor', function (Blueprint $table) {
            $table->dropForeign(['kecamatan_id']);   // hapus foreign key dulu
            $table->dropColumn('kecamatan_id');
        });
    }

    public function down(): void
    {
        Schema::table('sektor', function (Blueprint $table) {
            $table->unsignedBigInteger('kecamatan_id')->nullable()->after('name');
            $table->foreign('kecamatan_id')
                  ->references('id')
                  ->on('kecamatan')
                  ->onDelete('cascade');
        });
    }
};