<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubscriberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users =  \App\Models\User::pluck('id');

        $this->command->info('Creating user subscribers.');

        $users->each(function ($id) {
            $recordsCount = rand(300, 500);

            $this->command->info('Creating subscribers for user ' . $id . '.');

            \App\Models\Subscriber::factory($recordsCount)->create(['user_id' => $id]);
        });

        $this->command->info('User subscribers created.');
    }
}
