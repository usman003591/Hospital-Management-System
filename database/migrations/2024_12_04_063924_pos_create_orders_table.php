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
        Schema::create('pos_orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->nullable();
            $table->dateTime('order_date')->nullable();
            $table->decimal('total_amount', total: 8, places: 2)->nullable();
            $table->integer('total_items')->nullable();
            $table->unsignedInteger('cashier_id')->nullable();
            $table->foreign('cashier_id', 'cashier_id_fk_01')->references('id')->on('pos_cashiers');
            $table->unsignedInteger('patient_id')->nullable();
            $table->foreign('patient_id', 'patient_id_fk_01')->references('id')->on('patients');
            $table->unsignedInteger('payment_method_id')->nullable();
            $table->foreign('payment_method_id', 'payment_method_id_fk_01')->references('id')->on('pos_payment_methods');
            $table->unsignedInteger('order_status_id')->nullable();
            $table->foreign('order_status_id', 'order_status_id_fk_01')->references('id')->on('pos_order_statuses');
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
        Schema::dropIfExists('pos_orders');
    }
};
