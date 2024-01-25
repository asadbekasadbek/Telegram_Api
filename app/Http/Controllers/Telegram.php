<?php

namespace App\Http\Controllers;

use App\Traits\TelegramBotHelper;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
class Telegram extends Controller
{
    use TelegramBotHelper;

    public function SendMessage(Request $request)
    {
        return self::SendTelegramMessage($request->chatId, $request->message);
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
    public function TelegramPhoto(Request $request)
    {
//        $photo_path = 'https://avatars.mds.yandex.net/i?id=e62bde91d2d3ff5039a299e54bbe643da748fa96-10555985-images-thumbs&n=13';
        $photo_path = storage_path('app/public/img/OIG.jpg');
       return self::SendTelegramPhoto($request->chatId,$photo_path);
    }
    public function TelegramAudio(Request $request)
    {
//
        $photo_path = public_path('test.ogg');
        return self::SendTelegramAudio($request->chatId,$photo_path);
    }
}
