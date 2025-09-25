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
        Schema::create('deposit_slips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients');
            $table->foreignId('hospital_id')->constrained('hospitals');
            $table->dateTime('date_issued');
            $table->bigInteger('deposit_slip_number')->nullable();
            $table->string('counter_number');
            $table->decimal('amount_in_figures', 10, 2);
            $table->text('amount_in_words');
            $table->text('payment_purpose');
            $table->string('deposit_slip_file_name')->nullable();
            $table->string('deposit_slip_file_fullpath')->nullable();
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
        Schema::dropIfExists('deposit_slips');
    }
};
