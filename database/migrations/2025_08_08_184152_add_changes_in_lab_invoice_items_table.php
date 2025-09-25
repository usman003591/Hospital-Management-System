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
        Schema::table('lab_invoice_items', function (Blueprint $table) {
             $table->foreignId('investigation_id')->nullable()->constrained('investigations')->cascadeOnDelete();
            //  $table->text('invoice_sequence')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lab_invoice_items', function (Blueprint $table) {
            $table->dropForeign(['investigation_id']);
            $table->dropColumn('investigation_id');
        });
    }
};
