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
        Schema::table('pos_order_details', callback: function (Blueprint $table) {
            $table->unsignedBigInteger('pos_medicine_batch_id')->nullable(true);
            $table->foreign('pos_medicine_batch_id')->references('id')->on('pos_medicine_batches')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pos_order_details', function (Blueprint $table) {
            $table->dropForeign(['pos_medicine_batch_id']);
            $table->dropColumn('pos_medicine_batch_id');
        });
    }
};
