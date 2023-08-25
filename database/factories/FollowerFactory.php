<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Follower>
 */
class FollowerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'user_id' => \App\Models\User::factory(),
            'created_at' => $this->faker->dateTimeBetween('-3 months', 'now'),
            'updated_at' => fn (array $attributes) => $attributes['created_at']
        ];
    }
}
