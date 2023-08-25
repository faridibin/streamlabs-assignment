<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MerchSaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users =  \App\Models\User::pluck('id');

        $this->command->info('Creating user merch sales.');

        $users->each(function ($id) {
            $recordsCount = rand(300, 500);

            $this->command->info('Creating merch sales for user ' . $id . '.');

            \App\Models\MerchSale::factory($recordsCount)->create([
                'buyer_id' => function (array $attributes) {
                    return match ($attributes['buyer_type']) {
                        'follower' => \App\Models\Follower::inRandomOrder()->first(),
                        'subscriber' => \App\Models\Subscriber::inRandomOrder()->first(),
                    };
                },
                'user_id' => $id
            ]);
        });

        $this->command->info('User merch sales created.');
    }
}
