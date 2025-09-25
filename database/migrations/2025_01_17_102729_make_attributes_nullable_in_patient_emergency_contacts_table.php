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
        Schema::table('patient_emergency_contacts', function (Blueprint $table) {
            $table->string('name')->nullable()->change();
            $table->string('relation')->nullable()->change();
            $table->string('contact')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patient_emergency_contacts', function (Blueprint $table) {
            $table->string('name')->nullable(false)->change();
            $table->string('relation')->nullable(false)->change();
            $table->string('contact')->nullable(false)->change();
        });
    }
};
