<?php

namespace Tests\Feature;

use App\Event;
use App\Member;
use App\Officer;
use App\User;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class EventControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testAuthentication()
    {
        $response = $this->get('/events');

        $response->assertRedirect('/login');
    }

    public function testUnauthorized()
    {
        $member = factory(Member::class)->create();
        $memberOfficer = factory(Member::class)->create();
        $officer = factory(Officer::class)->create([
            'member_id' => $memberOfficer->id
        ]);
        $user = factory(User::class)->create([
            'member_id' => $member->id
        ]);
        $event = factory(Event::class)->create([
            'officer_id' => $officer->id
        ]);

        $response = $this->actingAs($user)->get('/events/create');
        $response2 = $this->actingAs($user)->post('/events');
        $response3 = $this->actingAs($user)->get('/events/' . $event->id . '/edit');
        $response4 = $this->actingAs($user)->put('/events/' . $event->id);
        $response5 = $this->actingAs($user)->delete('/events/' . $event->id);

        $response->assertStatus(403);
        $response2->assertStatus(403);
        $response3->assertStatus(403);
        $response4->assertStatus(403);
        $response5->assertStatus(403);
    }

    public function testAuthorization()
    {
        $member = factory(Member::class)->create();
        $officer = factory(Officer::class)->create([
            'member_id' => $member->id
        ]);
        $user = factory(User::class)->create([
            'member_id' => $member->id
        ]);
        $event = factory(Event::class)->create([
            'officer_id' => $officer->id
        ]);

        $response = $this->actingAs($user)->get('/events/create');
        $response2 = $this->actingAs($user)->post('/events');
        $response3 = $this->actingAs($user)->get('/events/' . $event->id . '/edit');
        $response4 = $this->actingAs($user)->put('/events/' . $event->id);
        $response5 = $this->actingAs($user)->delete('/events/' . $event->id);

        $response->assertStatus(200);
        $response3->assertStatus(200);
        $response5->assertStatus(200);
        /* Because we didn't send any information in the post request, the validator
         * should be redirecting us back to the login form on these two requests.
         */
        $response2->assertStatus(302);
        $response4->assertStatus(302);
    }

    public function testIndex()
    {
        $response = $this->get('/events');
    }

    public function testCreate()
    {

    }

    public function testStore()
    {
    }
}
