<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WelcomeController extends Controller
{
    function index(){

        /*  https://openweathermap.org/api  */
        $apiKey = $hostname = env("WEATHER_API_KEY");
        $url_weather_today = "api.openweathermap.org/data/2.5/weather?q=Kyiv&appid=".$apiKey."&units=metric&lang=ua";
        $url_weather_5days = "api.openweathermap.org/data/2.5/forecast?q=Kyiv&appid=".$apiKey."&units=metric&lang=ua";
        $response = Http::get($url_weather_5days);
        $data = json_decode($response->body(), true);
        dd($data);

        return view('welcome', ['data' => $data]);
    }
}
