<?php

namespace App\Http\Controllers;

use App\Traits\TelegramBotHelper;
use Illuminate\Http\Request;

class Telegram extends Controller
{
    use TelegramBotHelper;

    public function test(Request $request)
    {
        dd($request);
        return self::gtest($request->chatId,$request->message);
    }
    public function SendMessage(Request $request)
    {
        return self::SendTelegramMessage($request->chatId,$request->message);
    }

    public function SendReply(Request $request)
    {
        return self::SendTelegramReply($request->chatId, $request->message, $request->replyId);
    }

    public function DeleteMessage(Request $request)
    {
        return self::SendDeleteTelegramMessage($request->chatId, $request->messageId);
    }


    public function MessageEntity(Request $request)
    {
        $entities = [
            ["offset" => 0, "length" => 7, "type" => "bold"],
            ["offset" => 8, "length" => 7, "type" => "italic"],
            ["offset" => 16, "length" => 4, "type" => "underline"],
            ["offset" => 21, "length" => 4, "type" => "strikethrough"],
            ["offset" => 27, "length" => 11, "type" => "blockquote"],
            ["offset" => 40, "length" => 4, "type" => "code"],
            ["offset" => 45, "length" => 14, "type" => "code"],
            ["offset" => 60, "length" => 9, "type" => "spoiler"],
            [
                "offset" => 70,
                "length" => 14,
                "type" => "text_link",
                "url" => "https://core.telegram.org/bots/api#textquote",
            ],
        ];
        return self::SendTelegramMessageEntity($request->chatId, $request->messageText, $entities);
    }

}
