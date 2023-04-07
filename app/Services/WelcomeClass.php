<?php


namespace App\Services;



use Illuminate\Support\Facades\Http;

class WelcomeClass {
    public $cities;
    public $cities_where;

    public function __construct()
    {
        $this->cities = [
            "Dnipro"=>"Дніпро", "Donetsk"=>"Донецьк", "Zaporizhia"=>"Запоріжжя", "Kyiv"=>"Київ",
            "Kryvyi Rih"=>"Кривий Ріг", "Lviv"=>"Львів", "Mykolayiv"=>"Миколаїв", "Odessa"=>"Одеса",
            "Sevastopol"=>"Севастополь", "Kharkiv"=>"Харків"
        ];
        $this->cities_where = [
            "Dnipro"=>"Дніпрі", "Donetsk"=>"Донецьку", "Zaporizhia"=>"Запоріжжі", "Kyiv"=>"Києві",
            "Kryvyi Rih"=>"Кривому Розі", "Lviv"=>"Львові", "Mykolayiv"=>"Миколаєві", "Odessa"=>"Одессі",
            "Sevastopol"=>"Севастополі", "Kharkiv"=>"Харкові"
        ];
    }

    public static function cookie__city_check(){
        if(!isset($_COOKIE['city'])){
            setcookie('city', 'Kyiv', time()+60*60*24*30);  //  30 days
            return 'Kyiv';
        }else{
            return $_COOKIE['city'];
        }
    }

    public static function sort_days($data){
        $data = $data['list'];

        $cur_day = explode(' ', $data[0]['dt_txt'])[0];
        $index = 0;
        $days = [[], [], [], [], [], []];
        foreach ($data as $day){
            if($cur_day === explode(' ', $day['dt_txt'])[0]){
                array_push($days[$index], $day);
            }else{
                $cur_day = explode(' ', $day['dt_txt'])[0];
                $index++;
                array_push($days[$index], $day);
            }
        }
        $days = self::temp_min_max($days);
        return $days;
    }

    public static function with_sign($num){
        $num = round($num, 0);
        return $num > 0 ? "+".abs($num) : $num;
    }

    public static function temp_min_max($days){
        array_pop($days);
        foreach ($days as $key => $day){
            $temp_min = [];
            $temp_max = [];
            foreach ($day as $period){
                $tmp_min = $period['main']['temp_min'];
                $tmp_max = $period['main']['temp_max'];
                array_push($temp_min, $tmp_min);
                array_push($temp_max, $tmp_max);
            }
            $days[$key]['temp_min'] = explode('.', strval(self::with_sign(min($temp_min))))[0];
            $days[$key]['temp_max'] = explode('.', strval(self::with_sign(max($temp_max))))[0];
        }
        return $days;
    }

    public static function get_date($date){
        $y = substr($date[0]['dt_txt'], 0, 4);
        $m = substr($date[0]['dt_txt'], 5, 2);
        $d = substr($date[0]['dt_txt'], 8, 2);
        $t = substr($date[0]['dt_txt'], 11, 5);
        return ['day' => $d, 'month' => $m, 'year' => $y];
    }

    public static function get_weekday($date){
        $weekdays = ['Неділя', 'Понеділок', 'Вівторок', 'Середа', 'Четвер', 'П\'ятниця', 'Субота'];
        $week_num = date('w', strtotime(explode(' ', $date[0]['dt_txt'])[0]));
        return $weekdays[$week_num];
    }

    public static function get_month($date){
        $months = ['січня', 'лютого', 'березня', 'квітня', 'травня', 'червня', 'липня', 'серпня', 'вересня',
            'жовтня', 'листопада', 'грудня'];
        $month_num = intval(date('m', strtotime(explode(' ', $date[0]['dt_txt'])[0])));
        return $months[$month_num];
    }

    public static function get_weather($city){
        /*  https://openweathermap.org/api  */
        /*  https://openweathermap.org/img/w/04d.png    //  icon src example    */
        $apiKey = $hostname = env("WEATHER_API_KEY");
        $url_weather_today = "api.openweathermap.org/data/2.5/weather?q=".$city."&appid=".$apiKey."&units=metric&lang=ua";
        $url_weather_5days = "api.openweathermap.org/data/2.5/forecast?q=".$city."&appid=".$apiKey."&units=metric&lang=ua";
        $response = Http::get($url_weather_5days);
        $response = json_decode($response->body(), true);

        return $response;
    }
}
