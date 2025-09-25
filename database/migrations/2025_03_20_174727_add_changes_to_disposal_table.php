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
        Schema::table('cd_disposal', function (Blueprint $table) {
            $table->unsignedInteger('disposal_type_id')->nullable(true)->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cd_disposal', function (Blueprint $table) {
            $table->unsignedInteger('disposal_type_id')->nullable(false)->default(0)->change();

        });
    }
};
