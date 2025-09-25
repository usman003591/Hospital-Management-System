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
        Schema::create('cd_disposal', function (Blueprint $table) {
            $table->id(); 
            $table->integer('cd_id'); //foreign key
            $table->enum('disposal_type', [ 'referred_to_hospital', 'referred_to_specialist',
             'admission','discharged',
                'medical_advice',
                'death_deceased'
            ]);
            $table->unsignedInteger('disposal_type_id')->default(0);
            $table->dateTime('dated');
            $table->text('remarks')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
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
        Schema::dropIfExists('cd_disposal');
    }
};
