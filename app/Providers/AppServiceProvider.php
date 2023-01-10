<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        Gate::before(function($user) {
            if ($user->group=='admin') {
                return true;
            }
        });

        Gate::define('admin', function($user) {
            return $user->group=='admin';
        });

        Gate::define('checker', function($user) {
            return $user->group=='checker';
        });

        Gate::define('checkeronly', function($user) {
           return $user->group='checkeronly';
        });


        Gate::define('user', function($user) {
            return $user->group=='user';
        });
        //
    }
}
