<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\PersonalDetailsStorage;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(PersonalDetailsStorage::class, function ($app) {
            return PersonalDetailsStorage::createFromPath();
        });
    }
}
