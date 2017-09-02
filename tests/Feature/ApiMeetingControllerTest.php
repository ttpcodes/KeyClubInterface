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

use Laravel\Passport\Passport;

class ApiMeetingControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testAuthentication()
    {
        $response = $this->json('GET', '/api/meetings');

        $response->assertStatus(401);
    }

    public function testAuthorization()
    {
        $member = factory(Member::class)->create();
        // $user = factory(User::class)->create([
        //     'member_id' => $member->id
        // ]);
        $meeting = factory(Meeting::class)->create();
        Passport::actingAs(factory(User::class)->create([
            'member_id' => $member->id
        ]), ['*']);

        $response = $this->json('POST', '/api/meetings');
        $response2 = $this->json('PUT', '/api/meetings/' . $meeting->id);
        $response3 = $this->json('DELETE', '/api/meetings/' . $meeting->id);

        $response->assertStatus(403);
        $response2->assertStatus(403);
        $response3->assertStatus(403);
    }

    public function testIndex()
    {
        $member = factory(Member::class)->create();
        Passport::actingAs(factory(User::class)->create([
            'member_id' => $member->id
        ]), ['*']);

        $response = $this->json('GET', '/api/meetings');

        $response->assertStatus(200);
        $response->assertJson([
            'meetings' => true
        ]);
    }

    public function testStore()
    {
        //
    }

    public function testShow()
    {
        //
    }

    public function testUpdate()
    {
        $member = factory(Member::class)->create();
        $meeting = factory(Meeting::class)->create();
        factory(Officer::class)->create([
            'member_id' => $member->id
        ]);
        Passport::actingAs(factory(User::class)->create([
            'member_id' => $member->id
        ]), ['*']);

        // Test empty request.
        $response = $this->json('PUT', '/api/meetings/' . $meeting->id);
        $response->assertStatus(400);

        // Test proper request.
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
        $response2 = $this->json('PUT', '/api/meetings/' . $meeting->id, array_merge($meetingData, $formData));
        $response2->assertStatus(200);
        $response2->assertJson([
            'status' => true
        ]);
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
