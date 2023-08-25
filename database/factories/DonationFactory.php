<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Donation>
 */
class DonationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'amount' => $this->faker->randomFloat(2, 1, 500),
            'currency' => 'USD',
            'donation_message' => $this->faker->sentence(6, true),
            'donator_type' => $this->faker->randomElement(['follower', 'subscriber']),
            'donator_id' => function (array $attributes) {
                return match ($attributes['donator_type']) {
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
