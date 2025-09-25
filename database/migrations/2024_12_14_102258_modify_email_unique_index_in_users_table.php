<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Drop the existing unique constraint
        //Schema::table('users', function ($table) {
          //  $table->dropUnique('users_email_unique');
        //});

        // Add a partial unique index for the email column
      //  DB::statement('CREATE UNIQUE INDEX users_email_unique ON users (email) WHERE deleted_at IS NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the partial unique index
       // DB::statement('DROP INDEX users_email_unique');

        // Re-add the original unique constraint
      //  Schema::table('users', function ($table) {
            //$table->unique('email');
       // });
    }
};
