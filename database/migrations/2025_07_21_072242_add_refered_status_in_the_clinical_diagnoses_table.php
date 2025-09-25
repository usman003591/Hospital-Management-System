<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE clinical_diagnoses DROP CONSTRAINT clinical_diagnoses_status_check");

        $types = ['completed','pending','cancelled', 'referred'];
        $result = join( ', ', array_map(function ($value){
            return sprintf("'%s'::character varying", $value);
        }, $types));

        DB::statement("ALTER TABLE clinical_diagnoses ADD CONSTRAINT clinical_diagnoses_status_check CHECK (status::text = ANY (ARRAY[$result]::text[]))");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $types = ['completed','pending','cancelled'];
        $result = join( ', ', array_map(function ($value){
            return sprintf("'%s'::character varying", $value);
        }, $types));

        DB::statement("ALTER TABLE clinical_diagnoses ADD CONSTRAINT clinical_diagnoses_status_check CHECK (status::text = ANY (ARRAY[$result]::text[]))");
    }
};
