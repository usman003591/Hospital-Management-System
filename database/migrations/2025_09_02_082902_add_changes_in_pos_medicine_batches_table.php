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
              $table->dropColumn('purchase_price');
              $table->decimal('packet_price', 10, 2)->nullable(true);
              $table->decimal('packet_items', 10, 2)->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pos_medicine_batches', function (Blueprint $table) {
              $table->decimal('purchase_price', 10, 2)->nullable(true);
              $table->dropColumn('packet_price');
              $table->dropColumn('packet_items');
        });
    }
};
