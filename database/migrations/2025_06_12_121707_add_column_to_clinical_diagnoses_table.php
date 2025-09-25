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
            $table->text('manual_prescription_document')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clinical_diagnoses', function (Blueprint $table) {
            $table->dropColumn('manual_prescription_document');
        });
    }
};
