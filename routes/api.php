<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::controller(\App\Http\Controllers\TelegramWebhookController::class)->group(function () {
    Route::post('/telegram-bot/handle', 'handle');
});

Route::controller(\App\Http\Controllers\Telegram::class)->group(function () {

    Route::post('/telegram-bot/telegram-video', 'TelegramVideo');
    Route::post('/telegram-bot/telegram-document', 'TelegramDocument');
    Route::post('/telegram-bot/telegram-audio', 'TelegramAudio');
    Route::post('/telegram-bot/telegram_photo', 'TelegramPhoto');
    Route::post('/telegram-bot/telegram_send_message', 'SendMessage');
    Route::post('/telegram-bot/telegram-send-reply', 'SendReply');
    Route::post('/telegram-bot/telegram-send-reply', 'SendReply');
    Route::post('/telegram-bot/telegram-delete-message', 'DeleteMessage');
    Route::post('/telegram-bot/telegram-delete-message', 'DeleteMessageLater');
    Route::post('/telegram-bot/telegram-message-entity', 'MessageEntity');
    Route::post('/telegram-bot/text-quote', 'TextQuote');
    Route::post('/telegram-bot/telegram_get_forum_topic_icon_stickers','TelegramGetForumTopicIconStickers');
});
