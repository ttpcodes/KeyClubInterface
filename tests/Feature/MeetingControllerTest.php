<?php

namespace Tests\Feature;

use App\Meeting;
use App\Member;
use App\Officer;
use App\User;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MeetingControllerTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Runs tests to check if authentication works.
     *
     * This test simply checks if an unauthenticated request is redirected to the
     * login form, ensuring that the request should be going through the authentication
     * middleware.
     *
     * @return void
     */
    public function testAuthentication()
    {
        $response = $this->get('/meetings');

        $response->assertRedirect('/login');
    }

    public function testIndex()
    {
        $member = factory(Member::class)->create();
        $user = factory(User::class)->create([
            'member_id' => $member->id
        ]);

        $response = $this->actingAs($user)->get('/meetings');

        $response->assertStatus(200);
        $response->assertViewIs('meeting.index');
        $response->assertViewHas('meetings', Meeting::all());
    }

    public function testCreate()
    {
        $member = factory(Member::class)->create();
        $officer = factory(Officer::class)->create([
            'member_id' => $member->id
        ]);
        $user = factory(User::class)->create([
            'member_id' => $member->id
        ]);

        $response = $this->actingAs($user)->get('/meetings/create');
        $response->assertStatus(200);
        $response->assertViewIs('meeting.create');
    }

    public function testStore()
    {
        // Test empty requests.
        $member = factory(Member::class)->create();
        $officer = factory(Officer::class)->create([
            'member_id' => $member->id

        ]);
        $user = factory(User::class)->create([
            'member_id' => $member->id
        ]);

        $response = $this->actingAs($user)->post('/meetings');
        $response->assertStatus(302);
        // Redirects do not have an associated view, do not check for views.

        // Test normal requests.
        $faker = \Faker\Factory::create();
        $form = [
            'date_time' => $faker->dateTime,
            'information' => $faker->paragraph
        ];
        $response2 = $this->actingAs($user)->post('/meetings', $form);
        $response2->assertStatus(200);
        $response2->assertViewIs('meeting.index');
    }

    public function testShow()
    {
        $member = factory(Member::class)->create();
        $officer = factory(Officer::class)->create([
            'member_id' => $member->id
        ]);
        $user = factory(User::class)->create([
            'member_id' => $member->id
        ]);
        $meeting = factory(Meeting::class)->create();

        $response = $this->actingAs($user)->get('/meetings/' . $meeting->id);
        $response->assertStatus(200);
        $response->assertViewIs('meeting.show');
        // Strict value comparisons cannot be run here due to issues with Laravel's
        // model logistics.
        $response->assertViewHas('meeting');
    }

    public function testEdit()
    {
        $member = factory(Member::class)->create();
        $officer = factory(Officer::class)->create([
            'member_id' => $member->id
        ]);
        $user = factory(User::class)->create([
            'member_id' => $member->id
        ]);
        $meeting = factory(Meeting::class)->create();

        $response = $this->actingAs($user)->get('/meetings/' . $meeting->id . '/edit');
        $response->assertStatus(200);
        $response->assertViewIs('meeting.edit');
        $response->assertViewHas('meeting');
    }

    public function testUpdate()
    {
        // Create relevant test models.
        $member = factory(Member::class)->create();
        $officer = factory(Officer::class)->create([
            'member_id' => $member->id
        ]);
        $user = factory(User::class)->create([
            'member_id' => $member->id
        ]);
        $meeting = factory(Meeting::class)->create();

        // Test web route request.
        $faker = \Faker\Factory::create();
        $meetingData = [
            'date_time' => $faker->dateTime->format('Y-m-d H:i:s'),
            'information' => $faker->paragraph,
        ];
        $formData = [
            'members' => [
                $member->id, $member->id + 1
            ]
        ];
        $response = $this->actingAs($user)->put('/meetings/' . $meeting->id, array_merge($meetingData, $formData));
        $response->assertStatus(200);
        $response->assertViewIs('meeting.show');
        $response->assertViewHas('meeting');
    }

    public function testDelete()
    {
        // Create relevant test models.
        $member = factory(Member::class)->create();
        $officer = factory(Officer::class)->create([
            'member_id' => $member->id
        ]);
        $user = factory(User::class)->create([
            'member_id' => $member->id
        ]);
        $meeting = factory(Meeting::class)->create();

        $response = $this->actingAs($user)->delete('/meetings/' . $meeting->id);
        $response->assertStatus(302);
    }
}
