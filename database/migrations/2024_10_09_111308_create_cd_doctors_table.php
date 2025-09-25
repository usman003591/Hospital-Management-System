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
        Schema::create('cd_doctors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cd_id');       //Foreign Key
            $table->date('start_date');
            $table->date('end_date');
            $table->unsignedBigInteger('doctor_id');       //Foreign Key
            $table->timestamps();
            $table->softDeletes();
            $table->integer('created_by')->nullable()->unsigned();
            $table->integer('updated_by')->nullable()->unsigned();
            $table->integer('deleted_by')->nullable()->unsigned();

            $table->foreign('cd_id')->references('id')->on('clinical_diagnoses')->cascadeOnDelete();
            $table->foreign('doctor_id')->references('id')->on('doctors')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cd_doctors');
    }
};
