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
        Schema::create('role_rights_allowed', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->integer('role_right_id')->default(0);
            $table->integer('role_id')->default(0);
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
        Schema::dropIfExists('role_rights_allowed');
    }
};
