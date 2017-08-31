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
        if (Gate::allows('officer-actions')) {
            return true;
        }
    }

    /**
     * Determine whether the user can view the memberPolicy.
     *
     * @param  \App\User  $user
     * @param  \App\MemberPolicy  $memberPolicy
     * @return mixed
     */
    public function view(User $user, Member $memberPolicy)
    {
        return true;
    }

    /**
     * Determine whether the user can create memberPolicies.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can update the memberPolicy.
     *
     * @param  \App\User  $user
     * @param  \App\MemberPolicy  $memberPolicy
     * @return mixed
     */
    public function update(User $user, Member $memberPolicy)
    {
        return false;
    }

    /**
     * Determine whether the user can delete the memberPolicy.
     *
     * @param  \App\User  $user
     * @param  \App\MemberPolicy  $memberPolicy
     * @return mixed
     */
    public function delete(User $user, Member $memberPolicy)
    {
        return false;
    }
}
