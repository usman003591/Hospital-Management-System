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
        Schema::create('cd_complaints', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('complaint_id');       //Foreign Key
            $table->unsignedBigInteger('cd_id');       //Foreign Key
            $table->string('duration');
            $table->timestamps();
            $table->softDeletes();
            $table->integer('created_by')->nullable()->unsigned();
            $table->integer('updated_by')->nullable()->unsigned();
            $table->integer('deleted_by')->nullable()->unsigned();

            $table->foreign('complaint_id')->references('id')->on('complaints')->cascadeOnDelete();
            $table->foreign('cd_id')->references('id')->on('clinical_diagnoses')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cd_complaints');
    }
};
