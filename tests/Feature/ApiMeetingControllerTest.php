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

    public function testIndex()
    {
        $member = factory(Member::class)->create();
        Passport::actingAs(factory(User::class)->create([
            'member_id' => $member->id
        ]), ['*']);

        $response = $this->json('GET', '/api/meetings');

        $response->assertStatus(200);
        $response->assertJson(Meeting::all()->jsonSerialize());
    }

    public function testStore()
    {
        // Create relevant test models.
        $member = factory(Member::class)->create();
        factory(Officer::class)->create([
            'member_id' => $member->id
        ]);
        Passport::actingAs(factory(User::class)->create([
            'member_id' => $member->id
        ]), ['*']);

        $faker = \Faker\Factory::create();
        $form = [
            // For some odd reason, the time needs this formatting when used in
            // API routes.
            'date_time' => $faker->dateTime->format('Y-m-d H:i:s'),
            'information' => $faker->paragraph
        ];
        $response = $this->json('POST', '/api/meetings', $form);
        $response->assertJson($form);
    }

    public function testShow()
    {
        // Create relevant test models.
        $member = factory(Member::class)->create();
        factory(Officer::class)->create([
            'member_id' => $member->id
        ]);
        Passport::actingAs(factory(User::class)->create([
            'member_id' => $member->id
        ]), ['*']);
        $meeting = factory(Meeting::class)->create();

        $response = $this->json('GET', '/api/meetings/' . $meeting->id);
        $meeting->date_time = $meeting->date_time->format('Y-m-d H:i:s');
        $response->assertJson($meeting->jsonSerialize());
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
        $response2->assertJson($meetingData);
    }

    public function testDelete()
    {
        // Create relevant test models.
        $member = factory(Member::class)->create();
        $meeting = factory(Meeting::class)->create();
        factory(Officer::class)->create([
            'member_id' => $member->id
        ]);
        Passport::actingAs(factory(User::class)->create([
            'member_id' => $member->id
        ]), ['*']);

        $response = $this->json('DELETE', '/api/meetings/' . $meeting->id);
        $response->assertJson([
            'message' => 'Meeting deleted successfully.'
        ]);
    }
}
