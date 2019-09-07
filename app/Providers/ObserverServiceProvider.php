<?php

namespace App\Providers;

use App\Observers\RegistrationObserver;
use App\Observers\UserObserver;
use App\Registration;
use App\User;
use Illuminate\Support\ServiceProvider;

class ObserverServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
//        User::observe(UserObserver::class);
//        Registration::observe(RegistrationObserver::class);
    }
}
