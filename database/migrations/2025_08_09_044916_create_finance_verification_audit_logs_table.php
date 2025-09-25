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
        Schema::create('finance_verification_audit_logs', function (Blueprint $table) {
            $table->id();
            $table->enum('verifiable_type', ['pos_invoices', 'services_invoices', 'lab_invoices'])->default('services_invoices');
            $table->unsignedBigInteger('verifiable_type_id')->default(0);
            $table->string('old_value')->nullable(true);
            $table->string('new_value')->nullable(false);
            $table->unsignedBigInteger('changed_by')->default(0);
            $table->datetime('changed_at')->nullable(true);
            $table->text('remarks')->nullable(true);
            $table->text('ip_address')->nullable(true);
            $table->json('meta')->nullable(true);
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('finance_verification_audit_logs');
    }
};
