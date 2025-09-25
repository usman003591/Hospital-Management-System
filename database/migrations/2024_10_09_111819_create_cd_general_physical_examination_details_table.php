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
        Schema::create('cd_general_physical_examination_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cd_gpe_id');       //Foreign Key
            $table->unsignedBigInteger('gpe_id');       //Foreign Key
            $table->timestamps();
            $table->softDeletes();
            $table->integer('created_by')->nullable()->unsigned();
            $table->integer('updated_by')->nullable()->unsigned();
            $table->integer('deleted_by')->nullable()->unsigned();

            $table->foreign('cd_gpe_id')->references('id')->on('cd_general_physical_examinations')->cascadeOnDelete();
            $table->foreign('gpe_id')->references('id')->on('general_physical_examinations')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cd_general_physical_examination_details');
    }
};
