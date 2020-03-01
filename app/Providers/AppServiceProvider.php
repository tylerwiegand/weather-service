<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\OpenWeatherMap;
use App\WeatherInterface;

class AppServiceProvider extends ServiceProvider {

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        $this->app->bind('App\WeatherInterface', 'App\OpenWeatherMap');
    }
}
