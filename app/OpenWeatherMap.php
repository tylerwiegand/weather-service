<?php

namespace App;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

class OpenWeatherMap implements WeatherInterface {

    public function __construct() {
        $this->baseArgs = [
            'base_uri' => env('OPEN_WEATHER_MAP_URI'),
            'query'    => [
                'appid' => env('OPEN_WEATHER_MAP_KEY'),
            ],
            'http_errors' => false,
        ];
    }

    public function getWindFromWeather($weather) {
        $wind = [];
        $wind['speed'] = $weather['wind']['speed'] ?? 'unknown';
        $wind['direction'] = $weather['wind']['deg'] ?? 'unknown';

        return $wind;
    }

    public function getWeatherByZip( $zip ) {
        $weatherKey = "weather.zip.{$zip}";

        // Get from cache first
        if(Cache::has($weatherKey)) {
            return Cache::get($weatherKey);
        }

        $args = array_merge_recursive($this->baseArgs,
                            [
                                'query' => [
                                    'zip' => "{$zip},us",
                                ],
                            ]);

        $response = $this->getClient($args)->request('GET', 'weather');

        if($response->getStatusCode() === 200) {
            $response = json_decode($response->getBody()->getContents(), true);
            Cache::put($weatherKey, $response, 15);

            return $response;
        } else {
            return $response->getReasonPhrase();
        }
    }

    private function getClient( $args ) {
        return new Client($args);
    }
}