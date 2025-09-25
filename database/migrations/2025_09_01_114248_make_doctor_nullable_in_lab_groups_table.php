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
        Schema::table('lab_groups', function (Blueprint $table) {
            $table->unsignedBigInteger('doctor_id')->nullable()->default(null)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lab_groups', function (Blueprint $table) {
            $table->unsignedBigInteger('doctor_id')->default(0)->nullable(false)->change();
        });
    }
};
