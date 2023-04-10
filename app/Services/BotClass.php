<?php


namespace App\Services;


use Telegram\Bot\Laravel\Facades\Telegram;

class BotClass{
    /*  tg bot sdk get started - https://telegram-bot-sdk.com/docs/getting-started/installation */
    public $telegram;
    private $test_tg_group;

    public function __construct()
    {
//        $this->telegram = new Api(env("TELEGRAM_BOT_TOKEN"));
        $this->telegram = Telegram::bot()->getMe();
        $this->test_tg_group = env("TEST_TG_GROUP");
    }

    public function get_result(){return $this->telegram->getWebhookUpdates();}
    public function sendMessage($chat_id, $message){
        $this->telegram->sendMessage(['chat_id' => $chat_id, 'text' => $message, 'parse_mode' => 'HTML']);
    }
    public function replyMessage($chat_id, $message, $message_id){
        $this->telegram->sendMessage(['chat_id' => $chat_id, 'text' => $message, 'reply_to_message_id' => $message_id, 'parse_mode' => 'HTML']);
    }
    public function sendMessage_mark($chat_id, $message, $keyboard){
        $this->telegram->sendMessage(['chat_id' => $chat_id, 'text' => $message, 'reply_markup' => $keyboard,
            'parse_mode' => 'HTML']);
    }

}
