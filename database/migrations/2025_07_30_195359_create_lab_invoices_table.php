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
        Schema::create('lab_invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id')->nullable(true)->default(0);
            $table->unsignedBigInteger('doctor_id')->nullable(true)->default(0);
            $table->unsignedBigInteger('lab_group_id')->nullable(true)->default(0);
            $table->date('date_issued');
            $table->string('total_amount');
            $table->enum('invoice_payment_status', ['paid', 'unpaid', 'pending'])->default('paid');
            $table->string('discount_amount');
            $table->string('net_amount');
            $table->string('amount_received');
            $table->integer('receipt_number')->nullable(true);
            $table->string('receipt_file_name')->nullable(true);
            $table->string('receipt_file_full_path')->nullable(true);
            $table->integer('total_investigation_items')->nullable(true);
            $table->unsignedBigInteger('hospital_id')->default(1);
            $table->foreign('hospital_id')->references('id')->on('hospitals')->cascadeOnDelete();
            $table->tinyInteger('is_finance_verified')->default(0);
            $table->unsignedBigInteger('finance_verified_by')->nullable();
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
        Schema::dropIfExists('lab_invoices');
    }
};
