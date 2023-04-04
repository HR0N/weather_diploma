<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;

class WelcomeController extends Controller
{
    function index(){

        $city = cookie__city_check();

        /*  https://openweathermap.org/api  */
        /*  https://openweathermap.org/img/w/04d.png    //  icon src example    */
        $apiKey = $hostname = env("WEATHER_API_KEY");
        $url_weather_today = "api.openweathermap.org/data/2.5/weather?q=".$city."&appid=".$apiKey."&units=metric&lang=ua";
        $url_weather_5days = "api.openweathermap.org/data/2.5/forecast?q=".$city."&appid=".$apiKey."&units=metric&lang=ua";
        $response = Http::get($url_weather_5days);
        $data = json_decode($response->body(), true);

        return view('welcome', ['data' => $data]);
    }
}


function cookie__city_check(){
    if(!isset($_COOKIE['city'])){
        setcookie('city', 'Kyiv', time()+60*60*24*30);  //  30 days
        return 'Kyiv';
    }else{
        return $_COOKIE['city'];
    }
}
