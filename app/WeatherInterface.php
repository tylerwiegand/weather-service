<?php

namespace App;

interface WeatherInterface {

    public function getWeatherByZip( $zip );

    public function getWindFromWeather( $weather );
}