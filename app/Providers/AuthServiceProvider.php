<?php

namespace App\Providers;

use App\Event;
use App\Meeting;
use App\Member;

use App\Policies\EventPolicy;
use App\Policies\MeetingPolicy;
use App\Policies\MemberPolicy;

use Illuminate\Support\Facades\Log;

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
            if (isset($user->member->officer)) {
                Log::info('Officer instance found on member. Returning true on Gate officer-actions.');
                return true;
            }
            Log::info('Officer instance not found. Returning false on Gate officer-actions.');
            return false;
        });

        Passport::routes();
    }
}
