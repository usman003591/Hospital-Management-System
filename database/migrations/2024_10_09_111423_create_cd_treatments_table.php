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
        Schema::create('cd_treatments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cd_id');
            $table->unsignedBigInteger('medicine_id');
            $table->unsignedBigInteger('treatment_dosage_id');
            $table->unsignedBigInteger('treatment_duration_id');
            $table->unsignedBigInteger('treatment_dose_interval_id');
            $table->text('remarks')->nullable();
            $table->string('created_by');
            $table->string('updated_by')->nullable();
            $table->string('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('cd_id')
                  ->references('id')
                  ->on('clinical_diagnoses')
                  ->onDelete('cascade');
            $table->foreign('medicine_id')
                  ->references('id')
                  ->on('medicines')
                  ->onDelete('cascade');
            $table->foreign('treatment_dosage_id')
                  ->references('id')
                  ->on('treatment_dosage')
                  ->onDelete('cascade');
            $table->foreign('treatment_duration_id')
                  ->references('id')
                  ->on('treatment_duration')
                  ->onDelete('cascade');
            $table->foreign('treatment_dose_interval_id')
                  ->references('id')
                  ->on('treatment_dose_interval')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cd_treatments');
    }
};
