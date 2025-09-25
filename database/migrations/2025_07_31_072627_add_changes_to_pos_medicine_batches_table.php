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
        Schema::table('pos_medicine_batches', function (Blueprint $table) {
               $table->date('manufacturing_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pos_medicine_batches', function (Blueprint $table) {
                  $table->dropColumn('manufacturing_date');
        });
    }
};
