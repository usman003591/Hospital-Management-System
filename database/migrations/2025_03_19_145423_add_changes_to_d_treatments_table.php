<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('cd_treatments', function (Blueprint $table) {
            $table->unsignedBigInteger('treatment_frequency_id')->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cd_treatments', function (Blueprint $table) {
            $table->dropColumn('treatment_frequency_id');
        });
    }
};
