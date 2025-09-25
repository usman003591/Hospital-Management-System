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
        Schema::create('notification_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('notification_id');
            $table->foreign('notification_id')->references('id')->on('notifications')->onDelete('cascade');
            $table->unsignedBigInteger('notification_sender_id');
            $table->foreign('notification_sender_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('notification_receiver_id');
            $table->foreign('notification_receiver_id')->references('id')->on('users')->onDelete('cascade');
            $table->text('notification_title');
            $table->text('notification_message');
            $table->datetime('viewed_at')->nullable();
            $table->boolean('is_read')->default(false);
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
        Schema::dropIfExists('notification_users');
    }
};
