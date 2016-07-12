<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Validators\InArrayValidator;

class ValidatorsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('App\Validators\PersonalDetails\Gender', function () {
            return new InArrayValidator(array_keys(\Config::get('constants.personal_details.genders')));
        });
        $this->app->singleton('App\Validators\PersonalDetails\PreferredContactMode', function () {
            return new InArrayValidator(array_keys(\Config::get('constants.personal_details.contact_modes')));
        });
    }
}
