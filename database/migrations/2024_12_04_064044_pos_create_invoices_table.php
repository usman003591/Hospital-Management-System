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
        Schema::create('pos_invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->nullable();
            $table->dateTime('dateIssued')->nullable();
            $table->unsignedInteger('order_id')->nullable();
            $table->foreign('order_id', 'order_id_fk_02')->references('id')->on('pos_orders');
            $table->integer('discount_percentage')->nullable();
            $table->decimal('final_amount', total: 8, places: 2)->nullable();
            $table->string('invoice_file_name')->nullable();
            $table->string('invoice_file_path')->nullable();
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
        Schema::dropIfExists('pos_invoices');
    }
};
