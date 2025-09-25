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
       Schema::table('patients', function (Blueprint $table) {
       $table->integer('year_of_birth')->nullable()->after('age');
      });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        
        Schema::table('patients', function (Blueprint $table) {
            $table->dropColumn('year_of_birth');
        });
    }
};
