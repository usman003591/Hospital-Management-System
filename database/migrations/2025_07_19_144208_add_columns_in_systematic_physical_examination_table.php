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
        Schema::table('systematic_physical_examinations', function (Blueprint $table) {
            $table->enum('verification_status', ['pending', 'approved', 'rejected'])->default('approved');
            $table->boolean('is_manual')->default(0);
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->unsignedBigInteger('rejected_by')->nullable();
            $table->string('description')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('systematic_physical_examinations', function (Blueprint $table) {
            $table->dropColumn('verification_status');
            $table->dropColumn('is_manual');
            $table->dropColumn('approved_by');
            $table->dropColumn('rejected_by');
            $table->string('description')->nullable(false)->change();
        });
    }
};
