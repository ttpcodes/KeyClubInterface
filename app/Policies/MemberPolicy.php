<?php

namespace App\Policies;

use App\User;
use App\Member;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Gate;

class MemberPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        /* The if statement here guarantees that only true or null are returned,
         * rather than true or false, which is what we don't want or the function
         * will just reject all member cases.
         */
        if(Gate::forUser($user)->allows('officer-actions')) {
            return true;
        }
    }

    /**
     * Determine whether the user can view the memberPolicy.
     *
     * @param  \App\User  $user
     * @param  \App\Member  $member
     * @return mixed
     */
    public function view(User $user, Member $member)
    {
        return $user->member->id == $member->id;
    }

    /**
     * Determine whether the user can create members.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can update the member.
     *
     * @param  \App\User  $user
     * @param  \App\Member  $member
     * @return mixed
     */
    public function update(User $user, Member $member)
    {
        return $user->member->id == $member->id;
    }

    /**
     * Determine whether the user can delete the memberPolicy.
     *
     * @param  \App\User  $user
     * @param  \App\Member  $member
     * @return mixed
     */
    public function delete(User $user, Member $member)
    {
        return false;
    }
}
