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
        Schema::table('lab_groups', function (Blueprint $table) {
            $table->unsignedBigInteger('lab_invoice_id')->nullable(true);
            $table->foreign('lab_invoice_id')->references('id')->on('lab_invoices')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lab_groups', function (Blueprint $table) {
            $table->dropForeign(['lab_invoice_id']);
            $table->dropColumn('lab_invoice_id');
        });
    }
};
