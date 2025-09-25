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
            if (Schema::hasColumn('investigations', 'description')) {
                $table->text('description')->nullable()->change();
            } else {
                $table->text('description')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('investigations', function (Blueprint $table) {

            if (Schema::hasColumn('investigations', 'description')) {
                $table->dropColumn('description');
            }

        });
    }
};
