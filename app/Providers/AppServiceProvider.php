<?php

namespace App\Providers;

use App\Rules\TokenExist;
use Illuminate\Support\ServiceProvider;
use Schema;
use Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Schema::defaultStringLength(191);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('token_exist', TokenExist::class);
    }
}
