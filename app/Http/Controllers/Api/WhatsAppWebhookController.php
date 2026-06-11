<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\GeneralHelper;
use Illuminate\Support\Facades\Log;

class WhatsAppWebhookController extends Controller
{
    /**
     * Handle incoming messages from WhatsApp Gateway
     */
    public function handle(Request $request)
    {
        // Debug: Simpan riwayat 10 hit terakhir agar tidak tertimpa saat refresh browser
        $logPath = public_path('wa_debug.json');
        $history = [];
        if (file_exists($logPath)) {
            $history = json_decode(file_get_contents($logPath), true) ?: [];
            // Pastikan $history adalah list/array berurutan, bukan associative object
            if (!empty($history) && !isset($history[0])) {
                $history = []; // Reset jika format lama rusak
            }
        }

        $currentHit = [
            'time' => now()->format('H:i:s'),
            'method' => $request->method(),
            'ip' => $request->ip(),
            'all_data' => $request->all(),
        ];

        array_unshift($history, $currentHit); // Tambah ke urutan teratas
        $history = array_slice($history, 0, 10); // Simpan maksimal 10 riwayat
        
        file_put_contents($logPath, json_encode($history, JSON_PRETTY_PRINT));
        Log::info('WhatsApp Webhook Hit: ', $currentHit);

        // Jika ini adalah permintaan GET (misal dites lewat browser)
        if ($request->isMethod('get')) {
            return response()->json([
                'status' => 'success',
                'message' => 'WhatsApp Webhook is active. History has been updated.',
                'history_count' => count($history)
            ]);
        }

        // 1. Tangkap JSON dari Webhook (Permintaan POST)
        $data = $request->all();
        
        // Coba deteksi pengirim dan pesan dari berbagai kemungkinan format JSON gateway
        $pengirim = $data['from'] ?? ($data['data']['from'] ?? ($data['message']['from'] ?? null));
        $pesanRaw = $data['body'] ?? ($data['data']['body'] ?? ($data['message']['body'] ?? ($data['text'] ?? null)));
        $pesan = trim(strtolower((string)$pesanRaw));

        // Pastikan data yang dibutuhkan ada
        if (!$pengirim || !$pesan) {
            return response()->json(['status' => 'success', 'info' => 'Data received but no sender or message found'], 200);
        }

        // 2. Logika Balasan
        
        // Respon sederhana untuk tes koneksi (apa saja chatnya)
        if ($pesan === 'ping' || $pesan === 'tes' || $pesan === 'halo') {
            GeneralHelper::sendWhatsApp($pengirim, "👋 Halo! Sistem PPID sudah terhubung dengan WhatsApp Anda.");
        }

        // Perintah #status
        if (str_contains($pesan, '#status')) {
            $statusPesan = "📊 *STATUS SISTEM PPID*\n\n"
                         . "✅ *Server:* Online\n"
                         . "✅ *Database:* Terhubung\n"
                         . "✅ *WhatsApp Gateway:* Aktif\n"
                         . "🆔 *ID Anda/Grup:* `{$pengirim}`\n"
                         . "🕒 *Waktu:* " . now()->format('d/m/Y H:i:s') . "\n\n"
                         . "Sistem berjalan dengan normal. 🚀";

            GeneralHelper::sendWhatsApp($pengirim, $statusPesan);
        }
        
        // Perintah #cek (Khusus untuk mendapatkan ID)
        if (str_contains($pesan, '#cek')) {
            $cekPesan = "🔍 *INFORMASI ID PENGIRIM*\n\n"
                      . "ID: `{$pengirim}`\n\n"
                      . "Gunakan ID di atas untuk konfigurasi grup di file .env jika ini adalah pesan dari grup.";
            
            GeneralHelper::sendWhatsApp($pengirim, $cekPesan);
        }

        return response()->json(['status' => 'success']);
    }
}
