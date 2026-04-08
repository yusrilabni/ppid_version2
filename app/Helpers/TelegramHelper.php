<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelegramHelper
{
    public static function sendMessage($message)
    {
        $token = config('services.telegram.token');
        $chat_id = config('services.telegram.chat_id');

        if (!$token || !$chat_id || $chat_id === 'YOUR_CHAT_ID_HERE') {
            Log::warning('Telegram configuration is missing or Chat ID is still placeholder.');
            return false;
        }

        try {
            $response = Http::post("https://api.telegram.org/bot{$token}/sendMessage", [
                'chat_id' => $chat_id,
                'text' => $message,
                'parse_mode' => 'Markdown',
            ]);

            if ($response->failed()) {
                Log::error('Telegram error: ' . $response->body());
                return false;
            }

            return true;
        } catch (\Exception $e) {
            Log::error('Telegram exception: ' . $e->getMessage());
            return false;
        }
    }
}
