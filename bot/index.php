<?php
include_once('env.php');
use env\Env as env;
include_once "bot.php";
include_once('db.php');
use mydb\myDB as DB;

echo '<pre>';
echo var_dump('test');
echo '</pre>';

$tgbot = new TGBot(env::$TELEGRAM_BOT_TOKEN);
$db = new DB(env::class);
$env_chat_id = env::$stud_group;


$update = json_decode(file_get_contents('php://input'), TRUE);
$callback_query     =                        $update['callback_query'];
$callback_query_data =                         $callback_query['data'];
$callback_chat_id    =        $callback_query["message"]["chat"]["id"];
$callback_user       =   $update['callback_query']['from']['username'];
$callback_first_name = $update['callback_query']['from']['first_name'];
/*  get data from message   */
$result     =                      $tgbot->get_result();
$chat_id    =          $result['message']['chat']['id'];
$from_id    =          $result['message']['from']['id'];
$message_id =          $result['message']['message_id'];
$type       =        $result['message']['chat']['type'];
$username   =    $result['message']['from']['username'];
$first_name =  $result['message']['from']['first_name'];
$last_name  =   $result['message']['from']['last_name'];
if($result['message']['text'])         {$text = $result['message']['text'];} // check if message is text \ get text
if($result['message']['caption']){$caption = $result['message']['caption'];} // check if message is image with caption \ get caption





/*if($update){
    $tgbot->sendMessage('-645978616', $callback_query_data);
//    $tgbot->telegram->sendMessage(['chat_id' => $callback_chat_id, 'text' => $message, 'reply_markup' => $keyboard, 'parse_mode' => 'HTML']);
}*/
