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
        Schema::table('medicines', function (Blueprint $table) {
            $table->string('number')->nullable();
            $table->mediumText('description')->nullable();
            $table->string('image_name')->nullable();
            $table->string('image_path')->nullable();
            $table->string('cost')->nullable();
            $table->unsignedInteger('medicine_category_id')->nullable();
            $table->foreign('medicine_category_id', 'medicine_category_id_fk_01')->references('id')->on('pos_medicine_categories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('medicines', function (Blueprint $table) {
            $table->dropColumn('number');
            $table->dropColumn('description');
            $table->dropColumn('image_name');
            $table->dropColumn('image_path');
            $table->dropColumn('cost');
            $table->dropForeign('medicine_category_id_fk_01');
            $table->dropColumn('medicine_category_id');
        });
    }
};
