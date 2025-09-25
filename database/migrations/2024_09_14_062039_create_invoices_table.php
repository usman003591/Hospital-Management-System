<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id');
            $table->foreign('patient_id')->references('id')->on('patients')->cascadeOnDelete();      //Foriegn Key
            $table->date('date_issued');
            $table->string('total_amount');
            $table->unsignedBigInteger('invoice_payment_status_id');
            $table->foreign('invoice_payment_status_id')->references('id')->on('invoice_payment_statuses')->cascadeOnDelete();
            $table->string('discount_amount');
            $table->string('net_amount');
            $table->string('amount_received');
            $table->integer('receipt_number')->nullable(true);
            $table->string('receipt_file_name')->nullable(true);
            $table->string('receipt_file_full_path')->nullable(true);
            $table->integer('total_services')->nullable(true);
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
        Schema::dropIfExists('invoices');
    }
};
