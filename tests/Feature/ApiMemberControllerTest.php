<?php

namespace Tests\Feature;

use App\Member;
use App\Officer;
use App\User;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use Laravel\Passport\Passport;

class ApiMemberControllerTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Runs tests to check if authentication works.
     *
     * This test simply checks if an unauthenticated request is redirected to the
     * login form, ensuring that the request should be going through the authentication
     * middleware.
     *
     * This test, and the authorization test, assume that authenticated users are
     * checked via the other tests for functionality.
     *
     * @return void
     */
    public function testAuthentication()
    {
        $response = $this->json('GET', '/api/meetings');

        $response->assertStatus(401);
    }

    // /**
    //  * Runs tests to check if authorization works.
    //  *
    //  * This test runs by checking to see if all unauthorized requests against
    //  * our endpoints return a 403 status code. Theoretically, a 403 response code
    //  * means that the policy is being applied. The policy logic is tested in the
    //  * MemberPolicyTest unit test.
    //  *
    //  * @return void
    //  */
    // public function testAuthorization()
    // {
    //     $member = factory(Member::class)->create();
    //     $member2 = factory(Member::class)->create();
    //     Passport::actingAs(factory(User::class)->create([
    //         'member_id' => $member->id
    //     ]), ['*']);
    //
    //     $response2 = $this->json('POST', '/members');
    //     $response4 = $this->json('PUT', '/members/' . $member2->id);
    //     $response5 = $this->json('DELETE', '/members/' . $member2->id);
    //
    //     $response2->assertStatus(403);
    //     $response4->assertStatus(403);
    //     $response5->assertStatus(403);
    // }

    public function testIndex()
    {
        $member = factory(Member::class)->create();
        Passport::actingAs(factory(User::class)->create([
            'member_id' => $member->id
        ]), ['*']);

        $request = $this->json('GET', '/api/members');
        $request->assertStatus(200);
        $request->assertJson([
            '0' => true
        ]);
    }

    public function testStore()
    {
        $member = factory(Member::class)->create();
        factory(Officer::class)->create([
            'member_id' => $member->id
        ]);
        Passport::actingAs(factory(User::class)->create([
            'member_id' => $member->id
        ]), ['*']);

        // Test empty request.
        $request = $this->json('POST', '/api/members');
        $request->assertStatus(422);

        // Test proper request.
        $faker = \Faker\Factory::create();
        $formData = [
            'id' => $faker->randomNumber,
            'first' => $faker->firstName,
            'last' => $faker->lastName,
            'email' => $faker->safeEmail,
            'phone' => $faker->phoneNumber,
            'graduation' => $faker->year
        ];
        $request2 = $this->json('POST', '/api/members', $formData);
        $request2->assertStatus(200);
        $request2->assertJson([
            'member' => true
        ]);

        // Test that the service has properly stored the new member.
        $this->assertDatabaseHas('members', $formData);
    }

    public function testShow()
    {
        $member = factory(Member::class)->create();
        Passport::actingAs(factory(User::class)->create([
            'member_id' => $member->id
        ]), ['*']);
        $member2 = factory(Member::class)->create();

        // Test request against the same user.
        $request = $this->json('GET', '/api/members/' . $member->id);
        $request->assertStatus(200);
        $request->assertJson([
            'id' => true,
            'first' => true,
            'last' => true
        ]);
    }

    public function testUpdate()
    {
        $member = factory(Member::class)->create();
        Passport::actingAs(factory(User::class)->create([
            'member_id' => $member->id
        ]), ['*']);
        factory(Officer::class)->create([
            'member_id' => $member->id
        ]);

        // Test empty request.
        $request = $this->json('PUT', '/api/members/' . $member->id);
        $request->assertStatus(422);

        $faker = \Faker\Factory::create();
        $form = [
            'id' => $member->id,
            'first' => $faker->firstName,
            'last' => $faker->lastName,
            'email' => $faker->safeEmail,
            'phone' => $faker->phoneNumber,
            'graduation' =>$faker->year
        ];

        // Test proper request.
        $request2 = $this->json('PUT', '/api/members/' . $member->id, $form);
        $request2->assertStatus(200);
        $request2->assertJson([
            'member' => true
        ]);
        $this->assertDatabaseHas('members', $form);
    }

    public function testDelete()
    {
        $member = factory(Member::class)->create();
        $member2 = factory(Member::class)->create();
        Passport::actingAs(factory(User::class)->create([
            'member_id' => $member->id
        ]), ['*']);
        factory(Officer::class)->create([
            'member_id' => $member->id
        ]);

        $request = $this->json('DELETE', '/api/members/' . $member->id);
        $request->assertStatus(403);
        $request->assertJson([
            'error' => true
        ]);

        $request2 = $this->json('DELETE', '/api/members/' . $member2->id);
        $request2->assertJson([
            'message' => true
        ]);
        $this->assertDatabaseMissing('members', [
            'id' => $member2->id
        ]);
    }
}
