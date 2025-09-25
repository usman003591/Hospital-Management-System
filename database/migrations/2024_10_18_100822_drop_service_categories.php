<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        // Explicitly drop foreign key constraints in related tables
        Schema::table('invoice_services', function (Blueprint $table) {
            $table->dropForeign(['service_category_id']);  // Drop the foreign key constraint
        });

        // Now drop the service_categories table
        Schema::dropIfExists('service_categories');
    }



    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::create('service_categories', function (Blueprint $table) {
            $table->id();
            $table->string('service_name');
            $table->decimal('default_amount');
            $table->decimal('employee_amount');
            $table->decimal('resident_amount');
            $table->tinyInteger('status')->default(0);
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        // Re-add the foreign key constraint to the invoice_services table
        Schema::table('invoice_services', function (Blueprint $table) {
            $table->unsignedBigInteger('service_category_id')->nullable();
            $table->foreign('service_category_id')
                ->references('id')
                ->on('service_categories')
                ->cascadeOnDelete();
        });
    }
};
