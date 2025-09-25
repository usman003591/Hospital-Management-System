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
        Schema::table('pos_medicine_batches', function (Blueprint $table) {
                  $table->text('medicine_batch_number')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pos_medicine_batches', function (Blueprint $table) {
                  $table->dropColumn('medicine_batch_number');
        });
    }
};
