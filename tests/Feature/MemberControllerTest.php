<?php

namespace Tests\Feature;

use App\Member;
use App\Officer;
use App\User;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MemberControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testAuthentication()
    {
        $response = $this->get('/members');

        $response->assertRedirect('/login');
    }

    public function testUnauthorized()
    {
        $member = factory(Member::class)->create();
        $member2 = factory(Member::class)->create();
        $user = factory(User::class)->create([
            'member_id' => $member->id
        ]);

        $response = $this->actingAs($user)->get('/members/create');
        $response2 = $this->actingAs($user)->post('/members');
        $response3 = $this->actingAs($user)->get('/members/' . $member2->id . '/edit');
        $response4 = $this->actingAs($user)->put('/members/' . $member2->id);
        $response5 = $this->actingAs($user)->delete('/members/' . $member2->id);

        $response->assertStatus(403);
        $response2->assertStatus(403);
        $response3->assertStatus(403);
        $response4->assertStatus(403);
        $response5->assertStatus(403);
    }

    public function testAuthorization()
    {
        $member = factory(Member::class)->create();
        $member2 = factory(Member::class)->create();
        $officer = factory(Officer::class)->create([
            'member_id' => $member->id
        ]);
        $user = factory(User::class)->create([
            'member_id' => $member->id
        ]);

        $response = $this->actingAs($user)->get('/members/create');
        $response2 = $this->actingAs($user)->post('/members');
        $response3 = $this->actingAs($user)->get('/members/' . $member2->id . '/edit');
        $response4 = $this->actingAs($user)->put('/members/' . $member2->id);
        $response5 = $this->actingAs($user)->delete('/members/' . $member2->id);

        $response->assertStatus(200);
        $response3->assertStatus(200);
        $response5->assertStatus(200);
        /* Because we didn't send any information in the post request, the validator
         * should be redirecting us back to the login form on these two requests.
         */
        $response2->assertStatus(302);
        $response4->assertStatus(302);
    }
}
