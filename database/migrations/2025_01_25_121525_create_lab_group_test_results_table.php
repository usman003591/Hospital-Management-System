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
        Schema::create('lab_group_test_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lab_group_test_id')->constrained()->cascadeOnDelete();
            $table->foreignId('investigation_attached_field_id')->constrained('investigations_attached_fields', 'id')->cascadeOnDelete();
            $table->text('value');
            $table->text('name');
            $table->string('unit');
            $table->text('reference_value');
            $table->tinyInteger('mark_normal')->default(1);
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedInteger('created_by');
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedInteger('deleted_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lab_group_test_results');
    }
};
