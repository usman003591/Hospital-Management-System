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
        Schema::table('investigations', function (Blueprint $table) {
            $table->text('basic_info')->nullable();
            $table->text('working')->nullable();
            $table->text('faqs')->nullable();
            $table->text('results')->nullable();
            $table->text('why_get_tested')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('investigations', function (Blueprint $table) {
            $table->dropColumn('basic_info');
            $table->dropColumn('working');
            $table->dropColumn('faqs');
            $table->dropColumn('results');
            $table->dropColumn('why_get_tested');
        });
    }
};
