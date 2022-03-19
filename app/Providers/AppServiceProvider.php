<?php

namespace App\Providers;

use App\Models\MealType;
use App\Models\Package;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use View;

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
        $languages = ['ar', 'en'];
        App::setLocale('ar');
        Schema::defaultStringLength(255);
        date_default_timezone_set(env('TIME_ZONE', 'UTC'));

        $lang = request()->header('lang');
        if ($lang) {
            if (in_array($lang, $languages)) {
                App::setLocale($lang);
            } else {
                App::setLocale('ar');
            }
        }

        View::share('meal_types', MealType::get());
        View::share('packages', Package::get());
    }
}
