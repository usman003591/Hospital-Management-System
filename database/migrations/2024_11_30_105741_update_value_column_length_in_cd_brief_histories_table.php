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
        Schema::table('cd_brief_histories', function (Blueprint $table) {
            $table->text('value')->change(); // Modify the 'value' column to allow up to 1000 characters
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cd_brief_histories', function (Blueprint $table) {
            $table->text('value')->change(); // Revert back to 255 characters if rolled back
        });
    }
};
