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
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount', 19, 4);
            $table->enum('currency', ['USD'])->default('USD'); // <-- For now only USD is supported. More currencies can be added later.
            $table->longText('donation_message')->nullable();
            $table->enum('donator_type', ['follower', 'subscriber']); // <-- I added this column because I want to know who donated. Could be a follower or subscriber.
            $table->boolean('is_read')->default(false);
            $table->unsignedBigInteger('donator_id')->nullable(); // <-- I added this column because I want to know who donated. Could be a follower or subscriber.
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};
