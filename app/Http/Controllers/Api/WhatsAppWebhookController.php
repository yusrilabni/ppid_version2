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
        // Debug: Simpan info setiap kali rute ini dipanggil (baik GET maupun POST)
        $debugData = [
            'time' => now()->format('H:i:s'),
            'method' => $request->method(),
            'ip' => $request->ip(),
            'all_data' => $request->all(),
            'headers' => $request->headers->all(),
        ];

        file_put_contents(public_path('wa_debug.json'), json_encode($debugData));
        Log::info('WhatsApp Webhook Hit: ', $debugData);

        // Jika ini adalah permintaan GET (misal dites lewat browser)
        if ($request->isMethod('get')) {
            return response()->json([
                'status' => 'success',
                'message' => 'WhatsApp Webhook is active and wa_debug.json has been updated.'
            ]);
        }

        // 1. Tangkap JSON dari Webhook (Permintaan POST)
        $data = $request->all();

        // Pastikan data yang dibutuhkan ada
        if (!isset($data['from']) || !isset($data['body'])) {
            return response()->json(['status' => 'success', 'info' => 'Data received but incomplete'], 200);
        }

        $pengirim = $data['from']; // Bisa berupa nomor@c.us atau IDGrup@g.us
        $pesan = trim(strtolower($data['body']));

        // 2. Logika Balasan
        
        // Perintah #status
        if ($pesan === '#status') {
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
        if ($pesan === '#cek') {
            $cekPesan = "🔍 *INFORMASI ID PENGIRIM*\n\n"
                      . "ID: `{$pengirim}`\n\n"
                      . "Gunakan ID di atas untuk konfigurasi grup di file .env jika ini adalah pesan dari grup.";
            
            GeneralHelper::sendWhatsApp($pengirim, $cekPesan);
        }

        return response()->json(['status' => 'success']);
    }
}
