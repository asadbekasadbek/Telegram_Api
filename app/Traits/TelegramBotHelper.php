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


    public static function SendTelegramCopyMessages(
        int|string $chatId,
        int        $messageThreadId,
        int|string $fromChatId,
        array|int  $messageIds,
        ?bool      $disable_notification = null,
        ?bool      $protectContent = null,
        ?bool      $removeCaption = null
    ): JsonResponse
    {
        $url = self::Url('copyMessages');
        $params = [
            'chat_id' => $chatId,
            'message_thread_id' => $messageThreadId,
            'from_chat_id' => $fromChatId,
            'message_ids' => $messageIds,
        ];

        if ($disable_notification !== null) {
            $params['disable_notification'] = $disable_notification;
        }

        if ($protectContent !== null) {
            $params['protect_content'] = $protectContent;
        }

        if ($removeCaption !== null) {
            $params['remove_caption'] = $removeCaption;
        }

        $response = Http::post($url, $params)->json();

        return response()->json($response);
    }


    public function SendTelegramPhoto(
        int|string $chatId,
        string     $photo,
        ?string    $caption = null,
        ?string    $parseMode = 'HTML',
        ?int       $messageThreadId = null,
        ?array     $captionEntities = null,
        bool       $hasSpoiler = null,
        bool       $disableNotification = null,
                   $replyParameters = null,
                   $replyMarkup = null
    ): JsonResponse
    {
        $url = self::Url('sendPhoto');
        if (!filter_var($photo, FILTER_VALIDATE_URL)) {
            $photo = fopen($photo, 'r');
        }
        $params = [
            'chat_id' => $chatId,
            'parse_mode' => $parseMode,
            'photo' => $photo
        ];
        if ($caption !== null) {
            $params['caption'] = $caption;
        }
        if ($disableNotification !== null) {
            $params['disable_notification'] = $disableNotification;
        }
        // Add optional parameters if they are not null or false
        if ($messageThreadId !== null) {
            $params['message_thread_id'] = $messageThreadId;
        }

        if ($captionEntities !== null) {
            $params['caption_entities'] = json_encode($captionEntities);
        }

        if ($hasSpoiler !== null) {
            $params['has_spoiler'] = $hasSpoiler;
        }

        if ($replyParameters !== null) {
            $params['reply_parameters'] = $replyParameters;
        }

        if ($replyMarkup !== null) {
            $params['reply_markup'] = $replyMarkup;
        }

        $response = Http::asMultipart()->post($url, $params);


        return response()->json($response);
    }

    public static function SendTelegramAudio(
        int|string $chatId,
        string     $audio,
        ?string    $caption = null,
        ?string    $parseMode = 'HTML',
        ?int       $messageThreadId = null,
        ?array     $captionEntities = null,
        ?int       $duration = null,
        ?string    $performer = null,
        ?string    $title = null,
        ?string    $thumbnail = null,
        ?bool      $disableNotification = null,
        ?bool      $protectContent = null,
                   $replyParameters = null,
                   $replyMarkup = null
    ): JsonResponse
    {
        $url = self::Url('sendAudio');

        if (!filter_var($audio, FILTER_VALIDATE_URL)) {
            $audio = fopen($audio, 'r');
        }

        $params = [
            'chat_id' => $chatId,
            'parse_mode' => $parseMode,
            'audio' => $audio,
        ];

        if ($caption !== null) {
            $params['caption'] = $caption;
        }

        if ($messageThreadId !== null) {
            $params['message_thread_id'] = $messageThreadId;
        }

        if ($captionEntities !== null) {
            $params['caption_entities'] = $captionEntities;
        }

        if ($duration !== null) {
            $params['duration'] = $duration;
        }

        if ($performer !== null) {
            $params['performer'] = $performer;
        }

        if ($title !== null) {
            $params['title'] = $title;
        }

        if ($thumbnail !== null) {
            $params['thumb'] = $thumbnail;
        }

        if ($disableNotification !== null) {
            $params['disable_notification'] = $disableNotification;
        }

        if ($protectContent !== null) {
            $params['protect_content'] = $protectContent;
        }

        if ($replyParameters !== null) {
            $params['reply_parameters'] = $replyParameters;
        }

        if ($replyMarkup !== null) {
            $params['reply_markup'] = $replyMarkup;
        }

        $response = Http::asMultipart()->post($url, $params);


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
