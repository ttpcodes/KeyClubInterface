<?php

namespace Tests\Unit;

use App\Member;
use App\Officer;
use App\User;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MemberPolicyTest extends TestCase
{
    use DatabaseTransactions;

    public function testUnauthorized() {
        $member = factory(Member::class)->create();
        $user = factory(User::class)->create([
            'member_id' => $member->id
        ]);
        $member2 = factory(Member::class)->create();

        $this->assertTrue($user->can('view', $member));
        $this->assertTrue($user->can('update', $member));
        $this->assertTrue($user->cant('delete', $member));

        $this->assertTrue($user->cant('create', Member::class));
        $this->assertTrue($user->cant('view', $member2));
        $this->assertTrue($user->cant('update', $member2));
        $this->assertTrue($user->cant('delete', $member2));
    }

    public function testAuthorized() {
        $member = factory(Member::class)->create();
        $officer = factory(Officer::class)->create([
            'member_id' => $member->id
        ]);
        $user = factory(User::class)->create([
            'member_id' => $member->id
        ]);
        $member2 = factory(Member::class)->create();

        $this->assertTrue($user->can('create', Member::class));
        $this->assertTrue($user->can('view', $member2));
        $this->assertTrue($user->can('update', $member2));
        $this->assertTrue($user->can('delete', $member2));
    }
}
