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
        Schema::table('cd_diagnoses', function (Blueprint $table) {
            $table->text('remarks')->nullable(true);
            $table->unsignedBigInteger('diagnosis_category_id')->default(1);
            $table->foreign('diagnosis_category_id')->references('id')->on('diagnosis_categories')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cd_diagnoses', function (Blueprint $table) {
            $table->dropColumn('remarks');
            $table->dropForeign(['diagnosis_category_id']);
            $table->dropColumn('diagnosis_category_id');
        });
    }
};
