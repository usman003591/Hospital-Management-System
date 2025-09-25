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
            $table->unsignedBigInteger('pos_medicine_inventory_id')->nullable(true);
            $table->foreign('pos_medicine_inventory_id')->references('id')->on('pos_medicine_inventory')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pos_medicine_batches', function (Blueprint $table) {
              $table->dropForeign(['pos_medicine_inventory_id']);
              $table->dropColumn('pos_medicine_inventory_id');
        });
    }
};
