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
             $table->string('opd_slip_name')->nullable();
             $table->string('opd_slip_path')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clinical_diagnoses', function (Blueprint $table) {
            $table->dropColumn('opd_slip_name');
            $table->dropColumn('opd_slip_path');
        });
    }
};
