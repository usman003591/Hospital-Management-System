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
        Schema::create('lab_investigation_prices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('investigation_id')->default(1);
            $table->foreign('investigation_id')->references('id')->on('investigations')->cascadeOnDelete();
            $table->decimal('price', 10, 2);
            $table->date('valid_from');
            $table->date('valid_to');
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
        Schema::dropIfExists('lab_investigation_prices');
    }
};
