<?php

namespace App\Providers;

use App\Helpers\StringHelper;
use App\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

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
        Validator::extend('phone_number', function($attribute, $value, $parameters)
        {
            $value = StringHelper::detectPhoneNumber($value);

            if (! is_numeric($value)) {
                return false;
            }

            $strlen = strlen($value);

            $isValid = ($strlen >= 5 && $strlen <= 14);

            return $isValid;
        });

        Validator::extend('unique_phone_number', function($attribute, $value, $parameters)
        {
            $value = StringHelper::detectPhoneNumber($value);

            return is_null(User::where('phone_number_slug', $value)->first());
        });
    }
}
