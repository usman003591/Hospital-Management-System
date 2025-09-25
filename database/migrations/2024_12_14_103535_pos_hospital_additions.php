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
        Schema::table('pos_cashiers', function (Blueprint $table) {
            $table->unsignedInteger('hospital_id')->nullable();
            $table->foreign('hospital_id', 'hospital_id_fk_01')->references('id')->on('hospitals');
            $table->tinyInteger('access_level')->nullable()->default(3);
        });

        Schema::table('pos_invoices', function (Blueprint $table) {
            $table->unsignedInteger('hospital_id')->nullable();
            $table->foreign('hospital_id', 'hospital_id_fk_02')->references('id')->on('hospitals');
        });

        Schema::table('pos_medicine_inventory', function (Blueprint $table) {
            $table->unsignedInteger('hospital_id')->nullable();
            $table->foreign('hospital_id', 'hospital_id_fk_03')->references('id')->on('hospitals');
        });

        Schema::table('pos_orders', function (Blueprint $table) {
            $table->unsignedInteger('hospital_id')->nullable();
            $table->foreign('hospital_id', 'hospital_id_fk_04')->references('id')->on('hospitals');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pos_cashiers', function (Blueprint $table) {
            $table->dropForeign('hospital_id_fk_01');
            $table->dropColumn('hospital_id');
            $table->dropColumn('access_level');
        });

        Schema::table('pos_invoices', function (Blueprint $table) {
            $table->dropForeign('hospital_id_fk_02');
            $table->dropColumn('hospital_id');
        });

        Schema::table('pos_medicine_inventory', function (Blueprint $table) {
            $table->dropForeign('hospital_id_fk_03');
            $table->dropColumn('hospital_id');
        });

        Schema::table('pos_orders', function (Blueprint $table) {
            $table->dropForeign('hospital_id_fk_04');
            $table->dropColumn('hospital_id');
        });
    }
};
