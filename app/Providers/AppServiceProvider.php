<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\PersonalDetailsStorage;
use Pagerfanta\Pagerfanta;
use App\Paginator\Adapter\PersonalDetailsStorageAdapter;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Validator::extend('PersonalDetails.Gender', 'App\Validators\PersonalDetails\Gender');
        \Validator::extend('PersonalDetails.PreferredContactMode', 'App\Validators\PersonalDetails\PreferredContactMode');
        \Validator::extend('PersonalDetails.EmailExists', function($attribute, $value) {
            /** @var PersonalDetailsStorage $storage */
            $storage = $this->app->make(PersonalDetailsStorage::class);
            return is_null($storage->findByEmail($value));
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(PersonalDetailsStorage::class, function () {
            return PersonalDetailsStorage::createFromPath();
        });
        $this->app->singleton('PersonalDetails\Pagerfanta', function() {
            $adapter = new PersonalDetailsStorageAdapter($this->app->make(PersonalDetailsStorage::class));
            return new Pagerfanta($adapter);
        });
    }
}
