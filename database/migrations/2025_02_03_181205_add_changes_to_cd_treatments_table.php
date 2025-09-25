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
        Schema::table('cd_treatments', function (Blueprint $table) {
            $table->unsignedBigInteger('treatment_form_id')->nullable(true);
            $table->foreign('treatment_form_id')
            ->references('id')
            ->on('dosage_forms')
            ->onDelete('cascade');

            $table->unsignedBigInteger('treatment_route_id')->nullable(true);
            $table->foreign('treatment_route_id')
            ->references('id')
            ->on('medicine_routes')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cd_treatments', function (Blueprint $table) {
            $table->dropForeign(['treatment_form_id']);
            $table->dropColumn('treatment_form_id');

            $table->dropForeign(['treatment_route_id']);
            $table->dropColumn('treatment_route_id');
        });
    }
};
