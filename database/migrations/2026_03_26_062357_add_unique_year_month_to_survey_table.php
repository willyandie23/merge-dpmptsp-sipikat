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
        Schema::table('survey', function (Blueprint $table) {
            $table->unique(['year', 'month'], 'survey_year_month_unique');
        });
    }

    public function down(): void
    {
        Schema::table('survey', function (Blueprint $table) {
            $table->dropUnique('survey_year_month_unique');
        });
    }
};
