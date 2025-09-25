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
        Schema::table('deposit_slips', function (Blueprint $table) {
            $table->unsignedBigInteger('amount_in_figures')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('deposit_slips', function (Blueprint $table) {
            $table->decimal('amount_in_figures', 10, 2)->change();
        });
    }
};
