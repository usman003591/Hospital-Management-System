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
        Schema::create('cd_admissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ward_id')->references('id')->on('wards')->cascadeOnDelete();
            $table->foreignId('room_id')->references('id')->on('rooms')->cascadeOnDelete();
            $table->foreignId('bed_id')->references('id')->on('beds')->cascadeOnDelete();
            $table->foreignId('department_id')->references('id')->on('departments')->cascadeOnDelete();
            $table->dateTime('admission_date');
            $table->text('remarks')->nullable();
            $table->dateTime('discharge_date')->nullable();
            $table->integer('status');
            $table->timestamps();
            $table->softDeletes();
            $table->string('created_by');
            $table->string('updated_by')->nullable();
            $table->string('deleted_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cd_admissions');
    }
};
