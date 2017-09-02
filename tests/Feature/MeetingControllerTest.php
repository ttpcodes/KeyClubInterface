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


    public function testAuthorization()
    {
        $member = factory(Member::class)->create();
        $user = factory(User::class)->create([
            'member_id' => $member->id
        ]);
        $meeting = factory(Meeting::class)->create();

        $response = $this->actingAs($user)->get('/meetings/create');
        $response2 = $this->actingAs($user)->post('/meetings');
        $response3 = $this->actingAs($user)->get('/meetings/' . $meeting->id . '/edit');
        $response4 = $this->actingAs($user)->put('/meetings/' . $meeting->id);
        $response5 = $this->actingAs($user)->delete('/meetings/' . $meeting->id);

        $response->assertStatus(403);
        $response2->assertStatus(403);
        $response3->assertStatus(403);
        $response4->assertStatus(403);
        $response5->assertStatus(403);
    }

    public function testIndex()
    {
        $member = factory(Member::class)->create();
        $user = factory(User::class)->create([
            'member_id' => $member->id
        ]);

        $response = $this->actingAs($user)->get('/meetings');

        $response->assertStatus(200);
        // $response->assertViewIs('meeting/index');
        $response->assertViewHas('meetings');
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

        // Test normal requests.
        $faker = \Faker\Factory::create();
        $form = [
            'date_time' => $faker->dateTime,
            'information' => $faker->paragraph
        ];
        $response2 = $this->actingAs($user)->post('/meetings', $form);
        $response2->assertStatus(302);
        $this->assertDatabaseHas('meetings', $form);
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
        // $response->assertViewHas('meeting');
    }

    public function testUpdate()
    {
        $member = factory(Member::class)->create();
        $officer = factory(Officer::class)->create([
            'member_id' => $member->id
        ]);
        $user = factory(User::class)->create([
            'member_id' => $member->id
        ]);
        $meeting = factory(Meeting::class)->create();
        // Test empty request.
        $response = $this->actingAs($user)->put('/meetings/' . $meeting->id);
        $response->assertStatus(400);

        // Test the submission of the web form.
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
        $response2 = $this->actingAs($user)->put('/meetings/' . $meeting->id, array_merge($meetingData, $formData));
        $response2->assertStatus(200);
        $response2->assertViewHas('status', 200);
        $this->assertDatabaseHas('meetings', $meetingData);
        $this->assertDatabaseHas('meeting_member', [
            'meeting_id' => $meeting->id,
            'member_id' => $member->id
        ]);
        $this->assertDatabaseHas('missing_members', [
            'id' => $member->id + 1,
            'meeting_id' => $meeting->id
        ]);
    }

    public function testDelete()
    {
        //
    }
}
