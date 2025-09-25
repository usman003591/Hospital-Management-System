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
        Schema::create('pos_order_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('order_id')->nullable();
            $table->foreign('order_id', 'order_id_fk_01')->references('id')->on('pos_orders');
            $table->unsignedInteger('medicine_id')->nullable();
            $table->foreign('medicine_id', 'medicine_id_fk_02')->references('id')->on('medicines');
            $table->integer('quantity')->nullable();
            $table->decimal('unit_price', total: 8, places: 2)->nullable();
            $table->decimal('total_price', total: 8, places: 2)->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedInteger('deleted_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pos_order_details');
    }
};
