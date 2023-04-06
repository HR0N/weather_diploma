<?php

namespace App\Http\Controllers;

use App\Services\WelcomeClass;

class WelcomeController extends Controller
{
    function index(){

        $welcome = new WelcomeClass();

        $city = $welcome->cookie__city_check();

        $weather = $welcome->get_weather("Kharkiv");

        $days = $welcome->sort_days($weather);
        if( isset($days[5]) ){ unset($days[5]); }

//        dd($days);


        $data['days'] = $days;
        $data['welcome'] = $welcome;
        return view('welcome', ['data' => $data]);
    }
}

$cities = [
    "Dnipro", "Donetsk", "Zaporizhia", "Kyiv", "Kryvyi Rih",
    "Lviv", "Mykolayiv", "Odessa", "Sevastopol", "Kharkiv"
];
$cities_where = [
    "Дніпрі", "Донецьку", "Запоріжжі", "Києві", "Кривому Розі",
    "Львові", "Миколаєві", "Одессі", "Севастополі", "Харкові"
];


