<?php

namespace App\Http\Controllers;

use App\Traits\TelegramBotHelper;
use Illuminate\Http\Request;

class TelegramWebhookController extends Controller
{
    use TelegramBotHelper;
    public function handle(Request $request)
    {
        $bodyContent = $request->getContent();
        return self::SendTelegramMessage(991027867,"<pre>$bodyContent</pre>");
    }
}
