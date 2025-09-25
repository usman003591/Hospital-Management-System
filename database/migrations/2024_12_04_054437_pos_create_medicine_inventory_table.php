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
        Schema::create('pos_medicine_inventory', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('medicine_id')->nullable();
            $table->foreign('medicine_id', 'medicine_id_fk_01')->references('id')->on('medicines');
            $table->integer('quantity')->nullable();
            $table->integer('reorder_number')->nullable();
            $table->unsignedInteger('medicine_inventory_status_id')->nullable();
            $table->foreign('medicine_inventory_status_id', 'medicine_inventory_status_id_fk_01')->references('id')->on('pos_medicine_inventory_statuses');
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
        Schema::dropIfExists('pos_medicine_inventory');
    }
};
