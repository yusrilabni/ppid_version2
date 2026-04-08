<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelegramHelper
{
    /**
     * Escape special characters for Telegram Markdown.
     */
    public static function escapeMarkdown($text)
    {
        if (!$text) return '';
        // Characters to escape in Markdown: _, *, [, ], (, ), ~, `, >, #, +, -, =, |, {, }, ., !
        // But for standard Markdown we usually just need to handle _, *, [, ]
        return str_replace(['_', '*', '[', ']', '`'], ['\_', '\*', '\[', '\]', '\`'], $text);
    }

    public static function sendMessage($message)
    {
        $token = config('services.telegram.token');
        $chat_id = config('services.telegram.chat_id');

        if (!$token || !$chat_id || $chat_id === 'YOUR_CHAT_ID_HERE') {
            Log::warning('Telegram configuration is missing or Chat ID is still placeholder.');
            return false;
        }

        try {
            // Use timeout to prevent hanging in production
            $response = Http::timeout(5)->post("https://api.telegram.org/bot{$token}/sendMessage", [
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
