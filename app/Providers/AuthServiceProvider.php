<?php

namespace App\Providers;

use App\Event;
use App\Meeting;
use App\Member;

use App\Policies\EventPolicy;
use App\Policies\MeetingPolicy;
use App\Policies\MemberPolicy;

use Laravel\Passport\Passport;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Event::class => EventPolicy::class,
        Meeting::class => MeetingPolicy::class,
        Member::class => MemberPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('officer-actions', function($user) {
            return isset($user->member->officer);
        });

        Passport::routes();
    }
}
