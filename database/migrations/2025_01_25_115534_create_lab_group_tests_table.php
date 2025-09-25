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
        Schema::create('lab_group_tests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lab_group_id')->constrained()->cascadeOnDelete();
            $table->foreignId('investigation_id')->constrained()->cascadeOnDelete();
            $table->dateTime('dated');
            $table->enum('status', ['pending', 'collected', 'in_process', 'completed'])->default('pending');
            $table->string('generated_report_pdf_path')->nullable(true);
            $table->dateTime('received_date')->nullable(true);
            $table->dateTime('report_date')->nullable(true);
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedInteger('created_by');
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedInteger('deleted_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lab_group_tests');
    }
};
