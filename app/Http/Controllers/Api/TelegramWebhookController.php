<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PermohonanInformasi;
use App\Models\PermohonanResponse;
use App\Helpers\GeneralHelper;
use Illuminate\Support\Facades\Log;

class TelegramWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $update = $request->all();
        Log::info('Telegram Webhook received: ', $update);

        if (!isset($update['callback_query'])) {
            return response()->json(['ok' => true]);
        }

        $callbackQuery = $update['callback_query'];
        $data = $callbackQuery['data'];
        $chatId = $callbackQuery['message']['chat']['id'];
        $messageId = $callbackQuery['message']['message_id'];
        $fromName = $callbackQuery['from']['first_name'] ?? 'Admin Telegram';

        // Security check: Pastikan ini dari grup yang benar (opsional, tapi disarankan)
        $allowedChatId = config('services.telegram.chat_id');
        if ($chatId != $allowedChatId) {
            return response()->json(['ok' => true]);
        }

        if (str_starts_with($data, 'respond_awal_')) {
            $permohonanId = str_replace('respond_awal_', '', $data);
            $this->processAutoRespond($permohonanId, $fromName, $messageId);
        } elseif (str_starts_with($data, 'reject_permohonan_')) {
            $permohonanId = str_replace('reject_permohonan_', '', $data);
            $this->processAutoReject($permohonanId, $fromName, $messageId);
        }

        return response()->json(['ok' => true]);
    }

    private function processAutoRespond($id, $adminName, $messageId)
    {
        $permohonan = PermohonanInformasi::find($id);
        if (!$permohonan || $permohonan->status_permohonan != 'pending') return;

        // 1. Update Status
        $permohonan->status_permohonan = 'diproses';
        $permohonan->save();

        // 2. Create Response
        $autoMsg = "Laporan telah kami terima dan akan segera ditindaklanjuti. Proses tindak lanjut dilakukan paling lambat 7 hari kerja sesuai regulasi yang berlaku.";
        
        PermohonanResponse::create([
            'permohonan_informasi_id' => $permohonan->id,
            'user_id' => null, // Dibuat oleh sistem via Telegram
            'message' => $autoMsg,
            'response_type' => 'Respon Awal'
        ]);

        // 3. Notify back to Telegram (Edit original message to remove buttons and show success)
        $escAdmin = htmlspecialchars($adminName);
        $statusMsg = "<b>✅ BERHASIL DIRESPON</b>\n\n"
                   . "<b>🆔 ID:</b> #{$permohonan->unique_code}\n"
                   . "<b>👤 Pemohon:</b> " . htmlspecialchars($permohonan->nama_pemohon) . "\n"
                   . "<b>🛠️ Diproses Oleh:</b> {$escAdmin} (via Telegram)\n"
                   . "<b>📢 Status:</b> Diproses\n"
                   . "<b>📩 Pesan Auto:</b> \n<i>{$autoMsg}</i>";

        $this->updateTelegramMessage($messageId, $statusMsg);
    }

    private function processAutoReject($id, $adminName, $messageId)
    {
        $permohonan = PermohonanInformasi::find($id);
        if (!$permohonan || $permohonan->status_permohonan != 'pending') return;

        $permohonan->status_permohonan = 'ditolak';
        $permohonan->save();

        PermohonanResponse::create([
            'permohonan_informasi_id' => $permohonan->id,
            'user_id' => null,
            'message' => "Permohonan ditolak. Silakan hubungi admin untuk informasi lebih lanjut.",
            'response_type' => 'Tindaklanjut Permohonan'
        ]);

        $escAdmin = htmlspecialchars($adminName);
        $statusMsg = "<b>❌ PERMOHONAN DITOLAK</b>\n\n"
                   . "<b>🆔 ID:</b> #{$permohonan->unique_code}\n"
                   . "<b>🛠️ Ditolak Oleh:</b> {$escAdmin} (via Telegram)\n"
                   . "<b>📢 Status:</b> Ditolak";

        $this->updateTelegramMessage($messageId, $statusMsg);
    }

    private function updateTelegramMessage($messageId, $text)
    {
        $token = config('services.telegram.token') ?? env('TELEGRAM_BOT_TOKEN');
        $chatId = config('services.telegram.chat_id') ?? env('TELEGRAM_CHAT_ID');

        Http::post("https://api.telegram.org/bot{$token}/editMessageText", [
            'chat_id' => $chatId,
            'message_id' => $messageId,
            'text' => $text,
            'parse_mode' => 'HTML',
            'reply_markup' => json_encode(['inline_keyboard' => []]) // Hapus tombol setelah diklik
        ]);
    }
}
