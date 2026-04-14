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
        $token = "8684002355:AAEvGLpwQVKHF8nkmeznuLOjTclkU52pzlk";
        $chat_id = "-1003717845788"; // ID Supergroup baru hasil migrasi

        if (!$token || !$chat_id) {
            Log::warning('Telegram configuration is missing.');
            return false;
        }

        try {
            $payload = [
                'chat_id' => $chat_id,
                'text' => $message,
                'parse_mode' => 'HTML', // Ganti ke HTML agar lebih stabil
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
                // Ensure ID is clean and string
                $item['desa_id'] = preg_replace('/[^a-zA-Z0-9]/', '', (string)$item['desa_id']);
                // Ensure names are clean
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
                $id = preg_replace('/[^a-zA-Z0-9]/', '', (string)$unit['unit_id']);
                $opdData[$id] = [
                    'unit_id' => $id,
                    'unit_nama' => $unit['unit_nama'],
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
                    $id = preg_replace('/[^a-zA-Z0-9]/', '', (string)$item['desa_id']);
                    $wilayahData[$id] = [
                        'unit_id' => $id,
                        'unit_nama' => $item['desa_tipe'] . ' ' . $item['desa_nama'] . ' (Kec. ' . $kecamatan . ')',
                        'kecamatan' => $kecamatan,
                        'type' => 'WILAYAH'
                    ];
                }
            }
        }

        // Gabungkan: OPD dulu baru Wilayah
        $data = array_merge($opdData, $wilayahData);

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
        $units = self::getUnitData();
        return $units->map(function($unit) {
            $unit['unit_id'] = 'B64_' . base64_encode($unit['unit_id']);
            return $unit;
        });
    }
}
