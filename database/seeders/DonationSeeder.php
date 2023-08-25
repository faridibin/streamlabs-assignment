<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DonationSeeder extends Seeder
{
    /**
     * The array of messages to use for the donation messages.
     *
     * @var array<int, string>
     */
    protected array $messages = [
        'follower' => [
            'Just found your channel, and I\'m loving it!',
            'Your content is a breath of fresh air.',
            'Excited to join your community!',
            'Been hearing a lot about you. Can\'t wait to see more!',
            'Hello! New follower here!',
            'Your last stream was epic!',
            'So glad I found your stream!',
            'A friend recommended your channel. Let\'s see what the hype is about!',
            'Your content resonates with me. New follower here!',
            'Eagerly waiting for your next stream!',
            'Joining the gang! Cheers!',
            'Your energy is infectious!',
            'I\'ve seen some of your videos. Instant follow!',
            'Love the positivity here.',
            'Your community speaks highly of you. Happy to be here!',
            'Can\'t believe I just discovered your channel!',
            'Looking forward to your future content.',
            'Love the vibes here!',
            'Heard a lot about this community. Happy to be a part of it.',
            'Your last video was fantastic! Keep it up!',
            'Following for more of your awesome content!',
            'Stumbled upon your stream. Instant fan!',
            'Glad to be a part of your journey.',
            'You\'re doing amazing work!',
            'Can\'t wait to interact more!',
            'Your last stream was super informative. Thanks!',
            'New follower alert!',
            'Super excited to see what\'s next!',
            'You\'re genuinely unique in your approach. Love it!',
            'Been binge-watching your videos. Now following!',
            'Your passion shines through your content!',
            'Your streams are always a highlight of my day.',
            'Just in time for your next video. Can\'t wait!',
            'Joined the crew!',
            'Love the way you engage with your audience.',
            'Your last playthrough was hilarious!',
            'Happy to support your journey!',
            'Just subscribed! Your content is top-notch.',
            'Newbie here! Loving the vibes.',
            'Following for more of those epic moments!',
            'Keep up the amazing work!',
            'Can\'t wait to see what you have planned next.',
            'You\'re a hidden gem. Glad I found you!',
            'Here for the awesome content!',
            'Your tutorial videos are lifesavers!',
            'Your channel is a gold mine!',
            'Just clicked follow. Can\'t wait to see more!',
            'So excited for this new journey with you!',
            'I\'ve learned so much from your streams. Thank you!',
            'Following and never looking back!',
        ],
        'subscriber' => [
            'Been a follower for a while, thought it was time to subscribe!',
            'Here to support you even more!',
            'Totally worth the subscription!',
            'Your premium content is amazing!',
            'Happy to be an official subscriber now!',
            'You\'ve got a loyal subscriber in me!',
            'Your subscriber-only streams are epic!',
            'Let\'s take this relationship to the next level. Just subscribed!',
            'I believe in your content. Happy to subscribe!',
            'Subscribed! Your content has helped me a lot.',
            'Your last subscriber-only event was fantastic!',
            'Subscribed and excited for the perks!',
            'Glad to support your work!',
            'Your content deserves more recognition. Proud to be a subscriber!',
            'Being a subscriber has its perks. Loving the exclusive content!',
            'Subscribed! Keep up the outstanding work!',
            'Best decision ever! Your content rocks!',
            'Love your work! Subscribed without a second thought.',
            'Your subscriber-only chat is such a great idea!',
            'Being a part of this community as a subscriber feels special.',
            'Your subscriber benefits are totally worth it!',
            'Just upgraded my subscription! So worth it!',
            'Your dedication to your subscribers is admirable.',
            'Happy to support you monthly!',
            'Subscribed! Your content is refreshing.',
            'Your exclusive videos are top-notch!',
            'Subscribed for the awesome quality you bring!',
            'Being a subscriber has been such a rewarding experience.',
            'Just renewed my subscription! Best decision ever.',
            'The added benefits for subscribers are fantastic!',
            'Love being a part of the subscriber family!',
            'Subscribed for more of that exclusive content!',
            'Your hard work deserves support. Proud to be a subscriber!',
            'Your channel is going places, and I\'m happy to be a part of the journey.',
            'Every subscriber-only event is a blast!',
            'Upgraded my subscription! Can\'t get enough of your content.',
            'Proud to support your amazing content.',
            'Being a subscriber has been a fantastic experience!',
            'Looking forward to more subscriber-only streams!',
            'Subscribed and loving every moment!',
            'Here for the long haul! Your content is unbeatable.',
            'The perks of being a subscriber are endless!',
            'Just subscribed! Let the fun begin.',
            'Your commitment to subscribers is commendable.',
            'Here\'s to more epic content! Subscribed!',
            'Happy to support your incredible journey!',
            'Being a part of the inner circle as a subscriber is awesome!',
            'Your subscriber-only content never disappoints!',
            'Upgrading my subscription was a no-brainer!',
            'Subscribed! Here\'s to more epic moments together!'
        ],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users =  \App\Models\User::pluck('id');

        $this->command->info('Creating user donations.');

        $users->each(function ($id) {
            $recordsCount = rand(300, 500);

            $this->command->info('Creating donations for user ' . $id . '.');

            \App\Models\Donation::factory($recordsCount)->create([
                'donation_message' => fn (array $attributes) => $this->messages[$attributes['donator_type']][array_rand($this->messages[$attributes['donator_type']])],
                'donator_id' => function (array $attributes) {
                    return match ($attributes['donator_type']) {
                        'follower' => \App\Models\Follower::inRandomOrder()->first(),
                        'subscriber' => \App\Models\Subscriber::inRandomOrder()->first(),
                    };
                },
                'user_id' => $id
            ]);
        });

        $this->command->info('User donations created.');
    }
}
