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
        DB::statement("ALTER TABLE cd_disposal DROP CONSTRAINT cd_disposal_disposal_type_check");

        // Add a new check constraint with extra values
        DB::statement("
            ALTER TABLE cd_disposal
            ADD CONSTRAINT cd_disposal_disposal_type_check
            CHECK (disposal_type IN (
                'referred_to_hospital',
                'referred_to_specialist',
                'admission',
                'discharged',
                'medical_advice',
                'death_deceased',
                'follow_up',
                'referred_to_department'
            ))"
        );

        // Add new column
        Schema::table('cd_disposal', function (Blueprint $table) {
            $table->string('disposal_type_value')->nullable()->after('disposal_type_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cd_disposal', function (Blueprint $table) {
            $table->dropColumn('disposal_type_value');
        });

        // Drop the new constraint
        DB::statement("ALTER TABLE cd_disposal DROP CONSTRAINT cd_disposal_disposal_type_check");

        // Restore the old constraint (without the new values)
        DB::statement("
            ALTER TABLE cd_disposal
            ADD CONSTRAINT cd_disposal_disposal_type_check
            CHECK (disposal_type IN (
                'referred_to_hospital',
                'referred_to_specialist',
                'admission',
                'discharged',
                'medical_advice',
                'death_deceased'
            ))
        ");
    }
};
