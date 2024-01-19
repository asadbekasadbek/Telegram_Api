<?php

use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::controller(\App\Http\Controllers\Telegram::class)->group(function (){
    Route::post('telegram-bot/telegram_send_message', 'SendMessage');
    Route::post('telegram-bot/telegram-send-reply','SendReply');
    Route::post('telegram-bot/telegram-send-reply','SendReply');
    Route::post('telegram-bot/telegram-delete-message','DeleteMessage');
    Route::post('telegram-bot/telegram-delete-message','DeleteMessageLater');
    Route::post('telegram-bot/telegram-message-entity','MessageEntity');
    Route::post('telegram-bot/text-quote','TextQuote');
});
