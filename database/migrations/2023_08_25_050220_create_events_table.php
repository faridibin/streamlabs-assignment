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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->text('message');
            $table->enum('eventable_type', ['subscription', 'follower', 'donation', 'sale']);
            $table->unsignedBigInteger('eventable_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->index(['eventable_id', 'eventable_type']);
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
