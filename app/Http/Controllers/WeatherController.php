<?php

namespace App\Http\Controllers;

use App\WeatherInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;

class WeatherController extends Controller {

    public function __construct() {
        $this->weatherInterface = App::make(WeatherInterface::class);
    }

    public function getWindage( $zip, Request $request ) {
        $request->request->add(['zip' => $zip]);

        $validator = Validator::make($request->all(), [
            'zip' => 'min:5|max:5|postal_code:US',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }

        $weather = $this->weatherInterface->getWeatherByZip($zip);

        $wind = $this->weatherInterface->getWindFromWeather($weather);

        return response()->json($wind, 200);
    }
}
