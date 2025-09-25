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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('name_of_patient');
            $table->bigInteger('cnic_number');
            $table->date('date_of_birth');
            $table->enum('gender', ['male','female','other'])->default('male');
            $table->enum('patient_category', ['resident', 'non_resident', 'employee']);
            $table->longText('permanent_address');
            $table->string('phone');
            $table->string('cell')->nullable();
            $table->string('email')->nullable();
            $table->string('age')->nullable();
            $table->string('blood_group')->nullable();
            $table->string('reffering_doctor_name')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('address')->nullable();
            $table->string('patient_mr_number')->nullable();
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
        Schema::dropIfExists('patients');
    }
};
