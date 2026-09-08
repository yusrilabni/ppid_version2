<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\SecurityBlock;
use App\Helpers\GeneralHelper;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CheckSpamPermohonan
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $ip = $request->ip();

        // 1. Check if IP is explicitly blocked
        $isBlocked = SecurityBlock::where('ip_address', $ip)->exists();
        if ($isBlocked) {
            return response()->json([
                'success' => false,
                'message' => 'Akses Anda telah diblokir karena aktivitas mencurigakan sebelumnya.'
            ], 403);
        }

        // 2. Check for exact duplicate requests (Rate Limiting)
        // Only trigger this for non-GET requests
        if (!$request->isMethod('GET')) {
            $payloadForHash = $request->except(['_token', 'cara_memperoleh_informasi', 'cara_mendapatkan_salinan']);
            $payloadHash = md5(json_encode($payloadForHash));
            $rateLimitKey = 'spam_detect_' . $ip . '_' . $payloadHash;

            if (\Illuminate\Support\Facades\RateLimiter::tooManyAttempts($rateLimitKey, 2)) {
                // Get location data from IP
                $locationData = 'Tidak diketahui';
                try {
                    $response = Http::timeout(3)->get("http://ip-api.com/json/{$ip}");
                    if ($response->successful()) {
                        $data = $response->json();
                        if ($data['status'] === 'success') {
                            $locationData = $data['city'] . ', ' . $data['regionName'] . ', ' . $data['country'];
                        }
                    }
                } catch (\Exception $e) {
                    Log::error('Failed to get IP location: ' . $e->getMessage());
                }

                SecurityBlock::firstOrCreate(
                    ['ip_address' => $ip],
                    [
                        'reason' => 'Otomatis diblokir karena mengirim formulir yang sama lebih dari 2 kali',
                        'request_data' => $request->all()
                    ]
                );

                $tgMsg = "<b>⚠️ PERINGATAN KEAMANAN: Indikasi Bot/Spam (Duplikat)</b>\n\n"
                    . "<b>📍 IP:</b> {$ip}\n"
                    . "<b>🌍 Lokasi:</b> {$locationData}\n"
                    . "<b>🛑 Alasan:</b> Mengirim formulir yang identik lebih dari 2 kali.\n\n"
                    . "<i>IP ini telah otomatis dimasukkan ke daftar blokir.</i>";

                GeneralHelper::sendTelegramMessage($tgMsg);

                if ($request->wantsJson() || $request->is('api/*')) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Anda telah mengirim pesan yang sama beberapa kali. Akses Anda ditangguhkan untuk keamanan.'
                    ], 403);
                }

                return redirect()->back()->with('error', 'Anda telah mengirim pesan yang sama beberapa kali. Akses Anda ditangguhkan untuk keamanan.');
            }

            \Illuminate\Support\Facades\RateLimiter::hit($rateLimitKey, 600); // Track for 10 minutes
        }

        // 3. Check for spam words in the request
        $spamWords = config('spam_words', []);
        $requestData = json_encode($request->all());
        $requestDataLower = strtolower($requestData);

        $detectedSpam = [];
        foreach ($spamWords as $word) {
            if (strpos($requestDataLower, strtolower($word)) !== false) {
                $detectedSpam[] = $word;
            }
        }

        if (!empty($detectedSpam)) {
            // Get location data from IP
            $locationData = 'Tidak diketahui';
            try {
                $response = Http::timeout(3)->get("http://ip-api.com/json/{$ip}");
                if ($response->successful()) {
                    $data = $response->json();
                    if ($data['status'] === 'success') {
                        $locationData = $data['city'] . ', ' . $data['regionName'] . ', ' . $data['country'];
                    }
                }
            } catch (\Exception $e) {
                Log::error('Failed to get IP location: ' . $e->getMessage());
            }

            // Auto-block the IP (or just let admin block later? User says: 
            // "datanya bisa dikirim tappi ga bisa masuk server jadi filter semua kata katanyan ... pesan tidak dapat diterima karena kami mendeteksi hal mencurigakan")
            // We will save to a log instead of auto-block, or maybe save to security_blocks with a specific flag.
            // Let's just auto-block it because it's definitely spam.
            SecurityBlock::firstOrCreate(
                ['ip_address' => $ip],
                [
                    'reason' => 'Otomatis diblokir karena mendeteksi kata-kata: ' . implode(', ', $detectedSpam),
                    'request_data' => $request->all()
                ]
            );

            // Send to telegram
            $tgMsg = "<b>⚠️ PERINGATAN KEAMANAN: Serangan Spam Dicegat</b>\n\n"
                   . "<b>📍 IP:</b> {$ip}\n"
                   . "<b>🌍 Lokasi:</b> {$locationData}\n"
                   . "<b>🛑 Kata Terdeteksi:</b> " . implode(', ', $detectedSpam) . "\n\n"
                   . "<b>📄 Data Dikirim:</b>\n" . substr(htmlspecialchars($requestData), 0, 500) . "...\n\n"
                   . "<i>IP ini telah otomatis dimasukkan ke daftar blokir.</i>";

            GeneralHelper::sendTelegramMessage($tgMsg);

            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pesan tidak dapat diterima karena kami mendeteksi hal mencurigakan dari formulir yang Anda ajukan.'
                ], 403);
            }

            return redirect()->back()->with('error', 'Pesan tidak dapat diterima karena kami mendeteksi hal mencurigakan dari formulir yang Anda ajukan.');
        }

        return $next($request);
    }
}
