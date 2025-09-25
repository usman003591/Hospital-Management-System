<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::dropIfExists('appointment');

        Schema::create('appointment', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hospital_id');
            $table->date('date');
            $table->time('time');
            $table->unsignedBigInteger('appointment_request_id');
            $table->unsignedBigInteger('appointment_status_id');
            $table->unsignedBigInteger('patient_id')->nullable(true);
            $table->unsignedBigInteger('doctor_id');
            $table->tinyInteger('is_visitor');
            $table->timestamps();
            $table->softDeletes();
            $table->integer('created_by')->nullable()->unsigned();
            $table->integer('updated_by')->nullable()->unsigned();
            $table->integer('deleted_by')->nullable()->unsigned();

            //foreign keys
            $table->foreign('appointment_request_id')->references('id')->on('appointment_requests')->cascadeOnDelete();
            $table->foreign('appointment_status_id')->references('id')->on('appointment_statuses')->cascadeOnDelete();
            $table->foreign('hospital_id')->references('id')->on('hospitals')->cascadeOnDelete();
            $table->foreign('patient_id')->references('id')->on('patients')->cascadeOnDelete();
            $table->foreign('doctor_id')->references('id')->on('doctors')->cascadeOnDelete();
        });






    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointment');
    }
};
