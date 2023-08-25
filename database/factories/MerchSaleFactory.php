<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MerchSale>
 */
class MerchSaleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'item_name' => $this->faker->randomElement([
                't-shirt',
                'hoodie',
                'hat',
                'sticker',
                'poster',
            ]),
            'quantity' => $this->faker->numberBetween(1, 10),
            'price' => fn (array $attributes) => match ($attributes['item_name']) {
                't-shirt' => 20,
                'hoodie' => 40,
                'hat' => 15,
                'sticker' => 5,
                'poster' => 10,
            },
            'amount' => fn (array $attributes) => $attributes['price'] * $attributes['quantity'],
            'currency' => 'USD',
            'buyer_type' => $this->faker->randomElement(['follower', 'subscriber']),
            'buyer_id' => function (array $attributes) {
                return match ($attributes['buyer_type']) {
                    'follower' => \App\Models\Follower::factory(),
                    'subscriber' => \App\Models\Subscriber::factory(),
                };
            },
            'user_id' => \App\Models\User::factory(),
            'created_at' => $this->faker->dateTimeBetween('-3 months', 'now'),
            'updated_at' => fn (array $attributes) => $attributes['created_at']
        ];
    }
}
