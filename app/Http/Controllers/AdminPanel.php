<?php

namespace App\Http\Controllers;

use App\Models\TgGroup;
use App\Services\TgBotClass;
use App\Services\WelcomeClass;
use Illuminate\Http\Request;
use Telegram\Bot\Exceptions\TelegramResponseException;

class AdminPanel extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $welcome = new WelcomeClass();
        $data['groups'] = TgGroup::all();
        $data['cities'] = $welcome->cities;

        return view('adminpanel/adminpanel', ['data' => $data]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $base = TgGroup::find($id);
        $base->update($request->all());
        return $base;
    }

    /**
     * Update the specified resource in storage.
     */
    public function system_test(Request $request)
    {
        date_default_timezone_set('Europe/Kiev');
        $botClass = new TgBotClass();
        $welcome = new WelcomeClass();

        $bot = $botClass->bot;
        $groups = TgGroup::all();

        foreach ($groups as $v){
            $city = $v->city;
            $group_id = $v->group_id;
            $msg_type = $v->message_type;
            $msg_period = json_decode($v->message_period);
            $msg_allow = $v->allow_messages;
            $hour = explode(':', date('H:m'))[0];
            $message = 'Error';

            $weather = $welcome->get_weather($city);
            $days = $welcome->sort_days($weather);
            if( isset($days[5]) ){ unset($days[5]); }

            if(!$msg_allow) return;
            if($msg_type === '0'){
                $message = $botClass->newsletter_msg_0($days, $welcome);
            }else if($msg_type === '1'){
                $message = $botClass->newsletter_msg_1($days, $welcome);
            }

            try {
                $bot->sendMessage(['chat_id' => $group_id, 'text' => $message, 'parse_mode' => 'HTML']);
            } catch (TelegramResponseException $exception) {    // TelegramResponseException must be imported
                continue;
            }

//            $bot->sendMessage(['chat_id' => env('TEST_TG_GROUP'), 'text' => '$message', 'parse_mode' => 'HTML']);

        }

        return 'success';
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Sanding message to authenticated groups.
     */
    public function newsletter(string $token)
    {
        if($token != env('NEWSLETTER_TOKEN')) return '500';
        date_default_timezone_set('Europe/Kiev');
        $botClass = new TgBotClass();
        $welcome = new WelcomeClass();

        $bot = $botClass->bot;
        $groups = TgGroup::all();

        foreach ($groups as $v){
            $city = $v->city;
            $group_id = $v->group_id;
            $msg_type = $v->message_type;
            $msg_period = json_decode($v->message_period);
            $msg_allow = $v->allow_messages;
            $hour = explode(':', date('H:m'))[0];
            $message = 'Error';

            $weather = $welcome->get_weather($city);
            $days = $welcome->sort_days($weather);
            if( isset($days[5]) ){ unset($days[5]); }

            if(!$msg_allow) return;
            if($msg_type === '0'){
                $message = $botClass->newsletter_msg_0($days, $welcome);
            }else if($msg_type === '1'){
                $message = $botClass->newsletter_msg_1($days, $welcome);
            }

            foreach ($msg_period as $k => $v){
                if($v && $hour == $k){
                    try {
                        $bot->sendMessage(['chat_id' => $group_id, 'text' => $message, 'parse_mode' => 'HTML']);
                    } catch (TelegramResponseException $exception) {    // TelegramResponseException must be imported
                       continue;
                    }
                }
            }

        }
//        $bot->sendMessage(['chat_id' => env('TEST_TG_GROUP'), 'text' => '$message', 'parse_mode' => 'HTML']);

        return 'success';
    }
}
