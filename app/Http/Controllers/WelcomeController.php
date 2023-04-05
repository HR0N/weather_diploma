<?php

namespace App\Http\Controllers;

use App\Services\WelcomeClass;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;

class WelcomeController extends Controller
{
    function index(){

        $welcome = new WelcomeClass();

        $city = $welcome->cookie__city_check();

        /*  https://openweathermap.org/api  */
        /*  https://openweathermap.org/img/w/04d.png    //  icon src example    */
        $apiKey = $hostname = env("WEATHER_API_KEY");
        $url_weather_today = "api.openweathermap.org/data/2.5/weather?q=".$city."&appid=".$apiKey."&units=metric&lang=ua";
        $url_weather_5days = "api.openweathermap.org/data/2.5/forecast?q=".$city."&appid=".$apiKey."&units=metric&lang=ua";
        $response = Http::get($url_weather_5days);
        $response = json_decode($response->body(), true);

        $days = $welcome->sort_days($response);
        if( isset($days[5]) ){ unset($days[5]); }

//        dd($days);


        $data['days'] = $days;
        $data['welcome'] = $welcome;
        return view('welcome', ['data' => $data]);
    }
}



