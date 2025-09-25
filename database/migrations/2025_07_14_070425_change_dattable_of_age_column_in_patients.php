<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('patients', function (Blueprint $table) {
        // Optional: Clean non-numeric age data before altering
            DB::statement("UPDATE patients SET age = NULL WHERE age !~ '^[0-9]+$'");
            // Now convert the column
            DB::statement("ALTER TABLE patients ALTER COLUMN age TYPE INTEGER USING age::integer");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
                DB::statement("ALTER TABLE patients ALTER COLUMN age TYPE VARCHAR(255)");
        });
    }
};
