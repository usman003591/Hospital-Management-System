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
        Schema::create('role_rights', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('rights_slug')->nullable();
            $table->integer('role_right_module_id')->default(0);
            $table->integer('created_by')->nullable()->unsigned();
            $table->integer('deleted_by')->nullable()->unsigned();
            $table->integer('updated_by')->nullable()->unsigned();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_rights');
    }
};
