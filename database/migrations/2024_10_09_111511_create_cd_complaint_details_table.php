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
        Schema::create('cd_complaint_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cd_complaint_id');       //Foreign Key
            $table->unsignedBigInteger('complaint_id');       //Foreign Key
            $table->timestamps();
            $table->softDeletes();
            $table->integer('created_by')->nullable()->unsigned();
            $table->integer('updated_by')->nullable()->unsigned();
            $table->integer('deleted_by')->nullable()->unsigned();

            $table->foreign('cd_complaint_id')->references('id')->on('cd_complaints')->cascadeOnDelete();
            $table->foreign('complaint_id')->references('id')->on('complaints')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cd_complaint_details');
    }
};
