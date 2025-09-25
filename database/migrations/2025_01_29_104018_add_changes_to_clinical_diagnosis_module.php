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
        Schema::table('clinical_diagnoses', function (Blueprint $table) {
            $table->date('date')->nullable(true); // Store the date
            $table->integer('count')->default(0); // Store the count of users
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clinical_diagnoses', function (Blueprint $table) {
            $table->dropColumn('count');
            $table->dropColumn('date');
        });
    }
};
