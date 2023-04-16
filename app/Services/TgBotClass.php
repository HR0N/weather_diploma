<?php


namespace App\Services;




use App\Models\TgGroup;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\Laravel\Facades\Telegram;

class TgBotClass {

    /**
     * @var \Telegram\Bot\Api
     * @var string
     */
    public $bot;
    public $bot_id;

    public function __construct()
    {
        $this->bot = Telegram::bot('weatherBot');
        $this->bot_id = '5788363707';
    }


    public function getUpdates(){
        $result = null;
        try {
            $result = $this->bot->getWebhookUpdate();
        } catch (TelegramSDKException $e) {
            $result = $e->getMessage();
        }
        return $result;
    }

    public function bot_add($updates){
        if(isset($updates->new_chat_member->id) && $updates->new_chat_member->id == $this->bot_id){
            $data = [];
            $data['group_title'] = $updates->chat->title;
            $data['group_id'] = $updates->chat->id;
            TgGroup::create($data);
            return true;
        }
        return false;
    }

    public function bot_kick($updates){
        if(isset($updates->left_chat_member->id) && $updates->left_chat_member->id == $this->bot_id){
            $chat_id = $updates->chat->id;
            TgGroup::where('group_id', $chat_id)->delete();
            return true;
        }
        return false;
    }

    public function newsletter_msg_0($day, $welcome){
        $day = $day[0];
        $t_min = $day['temp_min'];
        $t_max = $day['temp_max'];
        $date = $welcome->get_date($day)['day'];
        $month = $welcome->get_month($day);
        $week_day = $welcome->get_weekday($day);
        return "$date $month. $week_day\n$t_min"."°"." $t_max"."°";
    }
    public function newsletter_msg_1($days, $welcome){
        $day = $days[0];
        $intervals = array_splice($day, 0, -2);
        $t_min = $day['temp_min'];
        $t_max = $day['temp_max'];
        $date = $welcome->get_date($intervals)['day'];
        $month = $welcome->get_month($intervals);
        $week_day = $welcome->get_weekday($intervals);
        $fells_like = $welcome->with_sign($intervals[0]['main']['feels_like']);
        $pressure = explode('.', strval($intervals[0]['main']['pressure'] / 1.333))[0];
        $humidity = $intervals[0]['main']['humidity'];
        $wind = $intervals[0]['wind']['speed'];
        return "$date $month. $week_day\n$t_min"."°"." $t_max"."°\n\nВідчувається як: $fells_like"."°"."\nТиск: $pressure"." мм"."\nВологість: $humidity"." %"."\nВітер: $wind"." м/сек";
    }
}
