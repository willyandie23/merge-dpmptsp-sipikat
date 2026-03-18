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
        Schema::table('produk_domestik', function (Blueprint $table) {
            $table->unsignedBigInteger('sektor_id')->nullable()->after('amount');

            // Foreign key
            $table->foreign('sektor_id')
                ->references('id')
                ->on('sektor')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('produk_domestik', function (Blueprint $table) {
            $table->dropForeign(['sektor_id']);
            $table->dropColumn('sektor_id');
        });
    }
};
