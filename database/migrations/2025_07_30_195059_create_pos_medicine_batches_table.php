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
        Schema::create('pos_medicine_batches', function (Blueprint $table) {
                $table->id();
                $table->foreignId('medicine_id')->constrained()->onDelete('cascade');
                $table->string('batch_number');
                $table->date('expiry_date');
                $table->integer('quantity');
                $table->integer('medicine_minimum_quantity')->default(0);
                $table->decimal('purchase_price', 8, 2);
                $table->decimal('selling_price', 8, 2);
                $table->string('barcode')->nullable(); // can store the encoded value
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
        Schema::dropIfExists('pos_medicine_batches');
    }
};
