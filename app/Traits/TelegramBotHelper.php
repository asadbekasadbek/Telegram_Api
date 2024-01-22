<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;

trait TelegramBotHelper
{
    private static function Url(string $type): string
    {
        $botToken = env('TELEGRAM_BOT_TOKEN');
        return "https://api.telegram.org/bot{$botToken}/$type";
    }

    public static function gtest(
        int|string $chatId,
        string     $message
    ): JsonResponse
    {
        $url = self::Url('sendMessage');
        $params = [
            'chat_id' => $chatId,
            'text' => $message,
            'parse_mode' => 'HTML',
        ];
        $response = Http::post($url, $params)->json();
        return response()->json($response);
    }

    public static function SendTelegramMessage(
        int|string $chatId,
        string     $message,
        ?string    $messageThreadId = null,
        string     $parseMode = 'HTML',
        ?array     $entities = null,
        ?bool      $disableNotification = null,
        ?bool      $protectContent = null,
                   $linkPreviewOptions = null,
                   $replyParameters = null,
                   $replyMarkup = null
    ): JsonResponse
    {
        $params = [
            'chat_id' => $chatId,
            'text' => $message,
            'parse_mode' => $parseMode,
        ];

        // Add parameters if they are not null
        if (!is_null($messageThreadId)) {
            $params['message_thread_id'] = $messageThreadId;
        }

        if (!is_null($entities)) {
            $params['entities'] = $entities;
        }

        if (!is_null($disableNotification)) {
            $params['disable_notification'] = $disableNotification;
        }

        if (!is_null($protectContent)) {
            $params['protect_content'] = $protectContent;
        }

        if (!is_null($linkPreviewOptions)) {
            $params['link_preview_options'] = $linkPreviewOptions;
        }

        if (!is_null($replyParameters)) {
            $params['reply_parameters'] = $replyParameters;
        }

        if (!is_null($replyMarkup)) {
            $params['reply_markup'] = $replyMarkup;
        }

        $url = self::Url('sendMessage');
        $response = Http::post($url, $params)->json();

        return response()->json($response);
    }

    public static function SendTelegramForwardMessage(
        int|string $chatId,
        int        $messageThreadId = null,
        int|string $fromChatId = null,
        ?bool      $disableNotification = null,
        ?bool      $protectContent = null,
        int        $messageId
    ): JsonResponse
    {
        $url = self::Url('forwardMessage');
        $params = [
            'chat_id' => $chatId,
            'message_id' => $messageId,
            'from_chat_id' => $fromChatId
        ];

        // Add parameters if they are not null

        if ($disableNotification !== null) {
            $params['disable_notification'] = $disableNotification;
        }

        if ($protectContent !== null) {
            $params['protect_content'] = $protectContent;
        }

        if ($messageThreadId !== null) {
            $params['message_thread_id'] = $messageThreadId;
        }

        $response = Http::post($url, $params)->json();

        return response()->json($response);
    }


    public static function SendTelegramForwardMessages(
        int|string $chatId,
        int        $messageThreadId,
        int|string $fromChatId,
        array|int  $messageIds,
        bool       $disable_notification = false,
        bool       $protectContent = false
    ): JsonResponse
    {
        $url = self::Url('forwardMessages');
        $params = [
            'chat_id' => $chatId,
            'message_thread_id' => $messageThreadId,
            'from_chat_id' => $fromChatId,
            'message_ids' => $messageIds,
            'disable_notification' => $disable_notification,
            'protect_content' => $protectContent
        ];

        $response = Http::post($url, $params)->json();

        return response()->json($response);
    }


    //<-- new up -->

    public static function SendTelegramReply(string $chatId, string $message, string $replyId, string $parseMode = 'HTML'): JsonResponse
    {
        $url = self::Url('sendMessage');
        $response = Http::post($url, [
            'chat_id' => $chatId,
            'text' => $message,
            'reply_to_message_id' => $replyId,
            'parse_mode' => $parseMode
        ])->json();
        return response()->json($response);

    }


    public static function SendDeleteTelegramMessage(string $chatId, string $messageId, ?int $seconds = 0): JsonResponse
    {
        $url = self::Url('deleteMessage');
        sleep($seconds);
        $response = Http::post($url, [
            'chat_id' => $chatId,
            'message_id' => $messageId
        ])->json();
        return response()->json($response);
    }

    public static function SendTelegramMessageEntity(string $chatId, string $messageText, array $entities): JsonResponse
    {
        $url = self::Url('sendMessage');
        $response = Http::post($url, [
            'chat_id' => $chatId,
            'text' => $messageText,
            'entities' => json_encode($entities),
        ]);
        return response()->json($response);
    }

}
