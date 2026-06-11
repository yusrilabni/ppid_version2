<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeneralHelper
{
    public static function generateUniqueCode($length = 5)
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public static function wordLimit($string, $limit = 3)
    {
        $words = explode(" ", $string);
        if (count($words) > $limit) {
            return implode(" ", array_slice($words, 0, $limit)) . "...";
        }
        return $string;
    }

    /**
     * Escape special characters for Telegram Markdown.
     */
    public static function escapeTelegramMarkdown($text)
    {
        if (!$text) return '';
        return str_replace(['_', '*', '[', ']', '`'], ['\_', '\*', '\[', '\]', '\`'], $text);
    }

    /**
     * Format phone number to international format (62...)
     */
    public static function formatPhoneNumber($phone)
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);
        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        } elseif (str_starts_with($phone, '8')) {
            $phone = '62' . $phone;
        }
        return $phone;
    }

    /**
     * Send message to Telegram Bot with optional buttons.
     */
    public static function sendTelegramMessage($message, $buttons = null)
    {
        $token = env('TELEGRAM_BOT_TOKEN', "8684002355:AAEvGLpwQVKHF8nkmeznuLOjTclkU52pzlk");
        $chat_id = env('TELEGRAM_CHAT_ID', "-1003717845788");

        if (!$token || !$chat_id) {
            Log::warning('Telegram configuration is missing.');
            return false;
        }

        try {
            $payload = [
                'chat_id' => $chat_id,
                'text' => $message,
                'parse_mode' => 'HTML',
            ];

            if ($buttons) {
                $payload['reply_markup'] = json_encode(['inline_keyboard' => $buttons]);
            }

            $response = Http::timeout(10)->post("https://api.telegram.org/bot{$token}/sendMessage", $payload);

            if ($response->failed()) {
                Log::error('Telegram error response: ' . $response->body());
                return false;
            }

            return true;
        } catch (\Exception $e) {
            Log::error('Telegram exception occurred: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Send message via WhatsApp Gateway
     */
    public static function sendWhatsApp($to, $message)
    {
        $apiUrl = env('WA_API_URL', 'http://36.95.15.72:3000/api/send');
        $apiKey = env('WA_API_KEY', '3047a8cc-6efd-4dfd-a4c6-dc7b3363de3f');

        if (!$apiUrl || !$apiKey) {
            Log::warning('WhatsApp Gateway configuration is missing.');
            return false;
        }

        // Jika bukan grup (@g.us), maka format sebagai nomor telepon internasional
        if (!str_contains($to, '@g.us')) {
            $to = self::formatPhoneNumber($to);
        }

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'x-api-key' => $apiKey
            ])->timeout(10)->post($apiUrl, [
                'to' => $to,
                'message' => $message
            ]);

            if ($response->failed()) {
                Log::error('WhatsApp Gateway error response: ' . $response->body());
                return false;
            }

            return true;
        } catch (\Exception $e) {
            Log::error('WhatsApp Gateway exception occurred: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Sinkronisasi data unit dan wilayah jika diperlukan (sekali sehari).
     */
    public static function getCachedUnits()
    {
        return self::syncExternalUnitsIfNeeded();
    }

    /**
     * Sinkronisasi data unit dan wilayah jika diperlukan (sekali sehari). Internal method.
     */
    public static function syncExternalUnitsIfNeeded()
    {
        $filePath = 'external_units.json';
        $today = now()->format('Y-m-d');

        // Cek apakah file ada dan apakah sudah disinkronisasi hari ini
        if (\Illuminate\Support\Facades\Storage::exists($filePath)) {
            $cached = json_decode(\Illuminate\Support\Facades\Storage::get($filePath), true);
            if (isset($cached['last_sync_date']) && $cached['last_sync_date'] === $today) {
                return $cached; // Sudah update hari ini, tidak perlu tarik API
            }
        }

        // Jika belum update hari ini, tarik dari API
        try {
            // 1. Get OPD Units
            $unitResponse = Http::timeout(10)->get('http://apps.sinjaikab.go.id/api/pegawai/get_unit');
            $units = $unitResponse->successful() ? $unitResponse->json() : [];

            // 2. Get Desa
            $desaResponse = Http::timeout(10)->get('http://apps.sinjaikab.go.id/api/pegawai/get_wilayah?tipe=Desa');
            $desaData = $desaResponse->successful() ? $desaResponse->json() : [];

            // 3. Get Kelurahan
            $kelurahanResponse = Http::timeout(10)->get('http://apps.sinjaikab.go.id/api/pegawai/get_wilayah?tipe=Kelurahan');
            $kelurahanData = $kelurahanResponse->successful() ? $kelurahanResponse->json() : [];

            // Grouping Wilayah by Kecamatan
            $allWilayah = collect(array_merge($desaData, $kelurahanData));
            $villagesGrouped = $allWilayah->map(function($item) {
                // Ensure IDs and names are string and trimmed
                $item['desa_id'] = (string)$item['desa_id'];
                $item['desa_nama'] = trim($item['desa_nama']);
                $item['kecamatan_nama'] = trim($item['kecamatan_nama']);
                return $item;
            })->sortBy('desa_nama')->groupBy('kecamatan_nama')->toArray();

            $finalData = [
                'units' => $units,
                'villages_grouped' => $villagesGrouped,
                'last_sync_date' => $today,
                'last_sync_time' => now()->format('H:i:s')
            ];

            \Illuminate\Support\Facades\Storage::put($filePath, json_encode($finalData));
            return $finalData;
        } catch (\Exception $e) {
            Log::error('Auto Sync Units Error: ' . $e->getMessage());
            // Jika gagal API, tetap gunakan data lama jika ada
            if (\Illuminate\Support\Facades\Storage::exists($filePath)) {
                return json_decode(\Illuminate\Support\Facades\Storage::get($filePath), true);
            }
        }

        return ['units' => [], 'villages_grouped' => []];
    }

    public static function getUnitData()
    {
        // Panggil sync otomatis (hanya akan tarik API jika user pertama di hari tersebut)
        $cached = self::syncExternalUnitsIfNeeded();
        
        $opdData = [];
        $wilayahData = [];
        
        // 1. Masukkan OPD
        if (!empty($cached['units'])) {
            foreach ($cached['units'] as $unit) {
                $id = (string)$unit['unit_id'];
                $opdData[$id] = [
                    'unit_id' => $id,
                    'unit_nama' => $unit['unit_nama'],
                    'unit_alamat' => $unit['unit_alamat'] ?? 'Alamat belum ditambahkan',
                    'type' => 'OPD'
                ];
            }
        }

        // 2. Masukkan Desa/Kelurahan
        if (!empty($cached['villages_grouped'])) {
            // Urutkan kecamatan agar rapi
            ksort($cached['villages_grouped']);
            foreach ($cached['villages_grouped'] as $kecamatan => $items) {
                foreach ($items as $item) {
                    $id = (string)$item['desa_id'];
                    $wilayahData[$id] = [
                        'unit_id' => $id,
                        'unit_nama' => $item['desa_tipe'] . ' ' . $item['desa_nama'] . ' (Kec. ' . $kecamatan . ')',
                        'unit_alamat' => 'Kabupaten Sinjai, Sulawesi Selatan',
                        'kecamatan' => $kecamatan,
                        'type' => 'WILAYAH'
                    ];
                }
            }
        }

        // Gabungkan: OPD dulu baru Wilayah, pastikan key (ID) tetap terjaga
        $data = $opdData;
        foreach ($wilayahData as $key => $value) {
            $data[$key] = $value;
        }

        // Jika cache benar-benar kosong, gunakan fallback hardcoded
        if (empty($data)) {
            return collect([
                '730701' => ['unit_id' => '730701', 'unit_nama' => 'Sekretariat Daerah', 'type' => 'OPD'],
            ]);
        }

        return collect($data);
    }

    /**
     * Khusus untuk Form Admin agar lolos Firewall (WAF)
     */
    public static function getEncodedUnitData()
    {
        // Berhenti menggunakan Encode karena ID Desa yang panjang pun sudah berhasil tanpa encode.
        // Kita akan menggunakan nama parameter yang berbeda di form untuk menghindari WAF 403.
        return self::getUnitData();
    }

    /**
     * Encode numeric ID to a short unique alphanumeric string.
     */
    public static function encodeId($id)
    {
        // Salt for slight obfuscation
        $salt = 778899;
        $encoded = base_convert(($id + $salt) * 3, 10, 36);
        return strtoupper($encoded);
    }

    /**
     * Decode the alphanumeric string back to numeric ID.
     */
    public static function decodeId($encoded)
    {
        try {
            $salt = 778899;
            $decoded = (base_convert(strtolower($encoded), 36, 10) / 3) - $salt;
            return (int) $decoded;
        } catch (\Exception $e) {
            return null;
        }
    }
}
