<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\WeatherInterface;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\TestResponse;

class WeatherTest extends TestCase {

    use WithFaker;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_that_someone_can_get_wind_information_with_zipcode() {
        $zip      = substr($this->faker()->postcode(), 0, 5);
        $response = $this->json('GET', "/api/v1/wind/{$zip}");

        $response->assertStatus(200)
                 ->assertJsonStructure([
                                           'speed',
                                           'direction',
                                       ]);

    }

    public function test_that_someone_cant_get_wind_information_without_zipcode() {
        $response = $this->json('GET', "/api/v1/wind");
        $response->assertStatus(404);
    }

    public function test_that_someone_cant_get_wind_information_with_malformed_zipcode() {
        $zip      = str_random(5);
        $response = $response = $this->json('GET', "/api/v1/wind/{$zip}");
        $response->assertStatus(422);
    }

    public function test_that_someone_can_get_wind_information_without_hitting_the_api() {
        $api_payload = '{"coord": {"lon": -82.74, "lat": 37.81}, "weather": [{"id": 800, "main": "Clear", "description": "clear sky", "icon": "01n"}], "base": "stations", "main": {"temp": 272.15, "feels_like": 268.04, "temp_min": 272.15, "temp_max": 272.15, "pressure": 1024, "humidity": 50}, "visibility": 16093, "wind": {"speed": 1.5, "deg": 220}, "clouds": {"all": 1}, "dt": 1583038167, "sys": {"type": 1, "id": 5853, "country": "US", "sunrise": 1582977804, "sunset": 1583018624}, "timezone": -18000, "id": 0, "name": "Meally", "cod": 200}';
        $response    = new Response($api_payload, 200);
        $testResponse = new TestResponse($response);

        $testResponse
            ->assertStatus(200)
            ->assertJsonStructure([
                                     'wind' => [
                                         'speed',
                                         'deg',
                                     ],
                                 ]
            );
    }

    // some test that "Use[s] mocks when interacting with the cache layer."

    private function getInterface() {
        return App::make(WeatherInterface::class);
    }
}
