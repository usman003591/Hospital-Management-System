<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('deposit_slips', function (Blueprint $table) {
            // First add the new column as nullable
            $table->foreignId('user_id')->nullable()->after('id');
        });

        // Here you would add your data migration logic
        // For example:
         DB::statement('UPDATE deposit_slips SET user_id = patient_id');

        Schema::table('deposit_slips', function (Blueprint $table) {
            // Make the column non-nullable after data migration
            $table->foreignId('user_id')->nullable(false)->change();

            // Add the foreign key constraint
            $table->foreign('user_id')->references('id')->on('users');

            // Drop the old foreign key and column
            $table->dropForeign(['patient_id']);
            $table->dropColumn('patient_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('deposit_slips', function (Blueprint $table) {
            // First add back the patient_id column as nullable
            $table->foreignId('patient_id')->nullable()->after('id');
        });

        // Here you would add your reverse data migration logic
        // For example:
         DB::statement('UPDATE deposit_slips SET patient_id = user_id');

        Schema::table('deposit_slips', function (Blueprint $table) {
            // Make the column non-nullable after data migration
            $table->foreignId('patient_id')->nullable(false)->change();

            // Add back the foreign key constraint
            $table->foreign('patient_id')->references('id')->on('patients');

            // Drop the new foreign key and column
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};
