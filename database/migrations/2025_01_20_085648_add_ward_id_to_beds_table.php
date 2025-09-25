<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('beds', function (Blueprint $table) {
            $table->foreignId('ward_id')->after('room_id')->nullable(true)->references('id')->on('wards')->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::table('beds', function (Blueprint $table) {
            $table->dropForeign(['ward_id']);
            $table->dropColumn('ward_id');
        });
    }
};
