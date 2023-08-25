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
        Schema::create('merch_sales', function (Blueprint $table) {
            $table->id();
            $table->string('item_name');
            $table->integer('quantity');
            $table->decimal('amount', 19, 4);
            $table->enum('currency', ['USD'])->default('USD'); // <-- For now only USD is supported. More currencies can be added later.
            $table->enum('buyer_type', ['follower', 'subscriber']); // <-- I added this column because I want to know who donated. Could be a follower or subscriber.
            $table->unsignedBigInteger('buyer_id')->nullable(); // <-- I added this column because I want to know who donated. Could be a follower or subscriber.
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
        Schema::dropIfExists('merch_sales');
    }
};
