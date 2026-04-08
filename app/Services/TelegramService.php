<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelegramService
{
    protected $token;
    protected $chat_id;

    public function __construct()
    {
        $this->token = config('services.telegram.token');
        $this->chat_id = config('services.telegram.chat_id');
    }

    public function sendMessage($message)
    {
        if (!$this->token || !$this->chat_id) {
            Log::warning('Telegram configuration is missing.');
            return false;
        }

        try {
            $response = Http::post("https://api.telegram.org/bot{$this->token}/sendMessage", [
                'chat_id' => $this->chat_id,
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
