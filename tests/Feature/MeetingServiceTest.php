<?php

namespace Tests\Feature;

use App\Meeting;
use App\Member;
use App\Officer;
use App\User;

use Illuminate\Foundation\Testing\RefreshDatabase;

use Tests\TestCase;

class MeetingServiceTest extends TestCase
{
    /**
     * Make sure that authorization works on all privileged requests.
     */
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

    public function testStore()
    {
        // Create the relevant models for the test.
        $member = factory(Member::class)->create();
        $officer = factory(Officer::class)->create([
            'member_id' => $member->id

        ]);
        $user = factory(User::class)->create([
            'member_id' => $member->id
        ]);

        // Test basic request validation.
        $response = $this->actingAs($user)->post('/meetings');
        $response->assertStatus(302);

        // Test basic data storage.
        $faker = \Faker\Factory::create();
        $form = [
            'date_time' => $faker->dateTime,
            'information' => $faker->paragraph
        ];
        $response2 = $this->actingAs($user)->post('/meetings', $form);
        $this->assertDatabaseHas('meetings', $form);
    }

    public function testUpdate()
    {
        // Create the relevant test models.
        $member = factory(Member::class)->create();
        $officer = factory(Officer::class)->create([
            'member_id' => $member->id
        ]);
        $user = factory(User::class)->create([
            'member_id' => $member->id
        ]);
        $meeting = factory(Meeting::class)->create();

        // Test basic data storage.
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

    public function testDestroy()
    {
        // Create the relevent test models.
        $member = factory(Member::class)->create();
        $officer = factory(Officer::class)->create([
            'member_id' => $member->id
        ]);
        $user = factory(User::class)->create([
            'member_id' => $member->id
        ]);
        $meeting = factory(Meeting::class)->create();

        // Test basic data storage.
        $this->actingAs($user)->delete('/meetings/' . $meeting->id);
        $this->assertDatabaseMissing('meetings', $meeting->jsonSerialize());
    }
}
