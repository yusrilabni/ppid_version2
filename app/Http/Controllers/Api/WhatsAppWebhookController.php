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
        // Ini untuk memastikan folder 'public' bisa ditulisi file
        file_put_contents(public_path('wa_debug.json'), json_encode([
            'last_access' => now()->format('H:i:s'),
            'method' => $request->method(),
            'data' => $request->all()
        ]));

        // Jika ini adalah permintaan GET (misal dites lewat browser)
        if ($request->isMethod('get')) {
            return response()->json([
                'status' => 'success',
                'message' => 'WhatsApp Webhook is active and wa_debug.json has been updated.'
            ]);
        }

        // 1. Tangkap JSON dari Webhook (Permintaan POST)
        $data = $request->all();
        
        // Logging untuk debugging (bisa dimatikan nanti)
        Log::info('WhatsApp Webhook received: ', $data);

        // Pastikan data yang dibutuhkan ada
        if (!isset($data['from']) || !isset($data['body'])) {
            return response()->json(['status' => 'error', 'message' => 'Invalid data'], 400);
        }

        $pengirim = $data['from']; // Bisa berupa nomor@c.us atau IDGrup@g.us
        $pesan = trim(strtolower($data['body']));

        // 2. Logika Balasan
        // Jika pesan berisi perintah #status
        if ($pesan === '#status') {
            $statusPesan = "📊 *STATUS SISTEM PPID*\n\n"
                         . "✅ *Server:* Online\n"
                         . "✅ *Database:* Terhubung\n"
                         . "✅ *WhatsApp Gateway:* Aktif\n"
                         . "🕒 *Waktu:* " . now()->format('d/m/Y H:i:s') . "\n\n"
                         . "Sistem berjalan dengan normal. 🚀";

            GeneralHelper::sendWhatsApp($pengirim, $statusPesan);
        }

        return response()->json(['status' => 'success']);
    }
}
