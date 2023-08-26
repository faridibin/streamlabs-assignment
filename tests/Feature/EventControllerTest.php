<?php

namespace Tests\Feature;

use App\Models\Donation;
use App\Models\Follower;
use App\Models\MerchSale;
use App\Models\Subscriber;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EventControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_retrieve_user_events()
    {
        $user = User::factory()->create();
        Follower::factory(10)->create(['user_id' => $user->id]);
        Donation::factory(3)->create(['user_id' => $user->id, 'amount' => 50]);
        Subscriber::factory(3)->create(['user_id' => $user->id, 'subscription_tier' => 'Tier2']);
        MerchSale::factory(3)->create(['user_id' => $user->id, 'amount' => 30]);

        $response = $this->actingAs($user)->getJson(route('events.index'));

        $response->assertStatus(200);
    }
}
