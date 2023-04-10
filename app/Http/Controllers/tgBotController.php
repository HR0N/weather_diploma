<?php

namespace App\Http\Controllers;

use App\Services\BotClass;
use Illuminate\Http\Request;
use Telegram\Bot\Laravel\Facades\Telegram;

class tgBotController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return 'test';
    }

    /*
        only POST methods allowed
        add exception in VerifyCsrfToken, example - https://stackoverflow.com/questions/46266553/why-does-the-laravel-api-return-a-419-status-code-on-post-and-put-methods
        hooks - https://stackoverflow.com/questions/42554548/how-to-set-telegram-bot-webhook
        405 Method Not Allowed - https://github.com/irazasyed/telegram-bot-sdk/issues/719
    */
    public function bot_hook()
    {
        $bot = Telegram::bot('weatherBot');
        $bot->sendMessage(['chat_id' => env('TEST_TG_GROUP'), 'text' => '$message', 'parse_mode' => 'HTML']);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
