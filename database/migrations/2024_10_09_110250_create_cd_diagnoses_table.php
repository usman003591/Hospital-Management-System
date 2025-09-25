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
        Schema::create('cd_diagnoses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cd_id');
            $table->unsignedBigInteger('diagnosis_id');
            $table->string('created_by');
            $table->string('updated_by')->nullable();
            $table->string('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('cd_id')
                  ->references('id')
                  ->on('clinical_diagnoses')
                  ->onDelete('cascade');
            $table->foreign('diagnosis_id')
                  ->references('id')
                  ->on('diagnosis')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cd_diagnoses');
    }
};
