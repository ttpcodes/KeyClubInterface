<?php

namespace App\Providers;

use App\Services\MeetingService;
use App\Services\MemberService;
use Illuminate\Support\ServiceProvider;

class ControllerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(MeetingService::class, function ($app) {
            return new MeetingService();
        });

        $this->app->singleton(MemberService::class, function ($app) {
            return new MemberService();
        });
    }
}
