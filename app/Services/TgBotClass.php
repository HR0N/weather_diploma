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
}
