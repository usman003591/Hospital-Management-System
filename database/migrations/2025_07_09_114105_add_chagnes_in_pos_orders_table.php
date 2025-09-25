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
        Schema::table('pos_orders', function (Blueprint $table) {
            $table->decimal('discount_amount', 10, 2)->after('total_amount')->default(0);
            $table->enum('discount_type', ['flat', 'percentage'])
                  ->default('percentage')
                  ->nullable()
                  ->after('total_amount');
            $table->decimal('discount_value', 10, 2)->nullable()->after('discount_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        Schema::table('pos_orders', function (Blueprint $table) {
            $table->dropColumn([
                'discount_amount',
                'total_amount',
                'discount_value'
            ]);
        });

    }
};
