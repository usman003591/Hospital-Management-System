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
        Schema::create('lab_invoice_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lab_invoice_id')->default(1);
            $table->foreign('lab_invoice_id')->references('id')->on('lab_invoices')->cascadeOnDelete();
            $table->unsignedBigInteger('investigation_price_id');
            $table->foreign('investigation_price_id')->references('id')->on('lab_investigation_prices')->cascadeOnDelete();
            $table->decimal('price', 10, 2);
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lab_invoice_items');
    }
};
