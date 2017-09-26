<?php

namespace App\Providers;

use Illuminate\Http\Request;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

use Laravel\Horizon\Horizon;

class HorizonServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Horizon::auth(function (Request $request) {
            if (app()->environment('local')) {
                return true;
            }
            return Gate::forUser($request->user())->allows('officer-actions');
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
