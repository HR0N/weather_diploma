<?php

namespace App\Http\Controllers;

use App\Services\WelcomeClass;

class WelcomeController extends Controller
{
    function index(){

        $welcome = new WelcomeClass();

        $city = $welcome->cookie__city_check();

        $weather = $welcome->get_weather($city);

        $days = $welcome->sort_days($weather);
        if( isset($days[5]) ){ unset($days[5]); }

//        dd($days);


        $data['days'] = $days;
        $data['welcome'] = $welcome;
        $data['cities'] = $welcome->cities;
        $data['cities_where'] = $welcome->cities_where;
        $data['current_city'] = $city;
        return view('welcome', ['data' => $data]);
    }


    function change_city($city){
        setcookie('city', $city, time()+60*60*24*30, '/');  //  30 days
    }
}







$cities = [
    "Dnipro"=>"Дніпро", "Donetsk"=>"Донецьк", "Zaporizhia"=>"Запоріжжя", "Kyiv"=>"Київ", "Kryvyi Rih"=>"Кривий Ріг",
    "Lviv"=>"Львів", "Mykolayiv"=>"Миколаїв", "Odessa"=>"Одеса", "Sevastopol"=>"Севастополь", "Kharkiv"=>"Харків"
];
$cities_where = [
    "Дніпрі", "Донецьку", "Запоріжжі", "Києві", "Кривому Розі",
    "Львові", "Миколаєві", "Одессі", "Севастополі", "Харкові"
];


