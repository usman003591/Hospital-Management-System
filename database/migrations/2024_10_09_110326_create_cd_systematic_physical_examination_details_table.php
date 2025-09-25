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
        Schema::create('cd_systematic_physical_examination_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cd_systematic_physical_examination_id');
            $table->unsignedBigInteger('spe_id');
            $table->string('created_by');
            $table->string('updated_by')->nullable();
            $table->string('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('cd_systematic_physical_examination_id')
                  ->references('id')
                  ->on('cd_systematic_physical_examinations')
                  ->onDelete('cascade');
            $table->foreign('spe_id')
                  ->references('id')
                  ->on('systematic_physical_examinations')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cd_systematic_physical_examination_details');
    }
};
