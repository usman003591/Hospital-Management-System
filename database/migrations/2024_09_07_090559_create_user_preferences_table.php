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
        Schema::create('user_preferences', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->deafult(0);
            $table->enum('theme', ['dark', 'light'])->default('light');
            $table->tinyInteger('rtl_mode')->default(0); //rtl_mode 1 for active and 0 for inactive
            $table->enum('layout', ['dark_sidebar', 'light_sidebar','dark_header','light_header'])->default('dark_sidebar');
            $table->enum('system_language', ['english','arabic'])->default('english');
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
        Schema::dropIfExists('user_preferences');
    }
};
