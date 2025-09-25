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
        Schema::table('cd_investigations', function (Blueprint $table) {
            $table->unsignedBigInteger('investigation_type_id');
            $table->foreign('investigation_type_id')
                    ->references('id')
                    ->on('investigation_types')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cd_investigations', function (Blueprint $table) {
             $table->dropForeign(['investigation_type_id']);  // Drop the foreign key constraint
             $table->dropColumn('investigation_type_id');
        });
    }
};
