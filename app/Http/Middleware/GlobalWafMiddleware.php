<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\SecurityBlock;
use App\Helpers\GeneralHelper;
use Illuminate\Support\Facades\Log;

class GlobalWafMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $ip = $request->ip();

        // 1. Cek apakah IP ini diblokir secara global
        if (SecurityBlock::where('ip_address', $ip)->exists()) {
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json(['success' => false, 'message' => 'Access Denied: Blocked IP'], 403);
            }
            abort(403, 'Akses ditolak. IP Anda terdeteksi melakukan aktivitas berbahaya.');
        }

        // 2. Definisi pola serangan (SQL Injection, XSS, Path Traversal)
        $attackPatterns = [
            // SQL Injection
            '/(?i)(union\s+select|select\s+.*\s+from|insert\s+into|update\s+.*\s+set|delete\s+from|drop\s+table|truncate\s+table|alter\s+table|exec(\s|\+)+(s|x)p\w+)/',
            '/(?i)(or|and)\s+(\d+|\'[\w\s]+\')\s*(=|<|>)/',
            
            // XSS (Script tags, event handlers)
            '/(?i)(<script.*?>.*?<\/script>|<script.*?>)/',
            '/(?i)(javascript:|vbscript:|data:text\/html)/',
            '/(?i)(onerror=|onload=|onclick=|onmouseover=|onfocus=|onblur=)/',
            
            // Path Traversal / LFI
            '/(?i)(\.\.\/|\.\.\\\\|\/etc\/passwd|c:\\\\windows)/'
        ];

        // 3. Ambil semua data request kecuali token & password
        $inputData = $request->except(['_token', 'password', 'password_confirmation']);
        $payloadString = json_encode($inputData);
        
        $detectedAttack = null;
        
        // Cek hanya jika bukan array kosong
        if (!empty($inputData)) {
            foreach ($attackPatterns as $pattern) {
                if (preg_match($pattern, $payloadString, $matches)) {
                    $detectedAttack = $matches[0];
                    break;
                }
            }
        }

        // Jika terdeteksi pola serangan
        if ($detectedAttack) {
            $userAgent = $request->userAgent() ?? 'Unknown Device';
            
            $requestDataWithDevice = array_merge($request->all(), [
                '_device_info' => $userAgent
            ]);

            // Log ke database SecurityBlock
            SecurityBlock::firstOrCreate(
                ['ip_address' => $ip],
                [
                    'reason' => 'Otomatis diblokir oleh WAF. Pola terdeteksi: ' . $detectedAttack,
                    'request_data' => $requestDataWithDevice
                ]
            );

            // Kirim notifikasi Telegram
            $tgMsg = "<b>🛡️ GLOBAL WAF ALERT: Serangan Terdeteksi</b>\n\n"
                   . "<b>📍 IP:</b> {$ip}\n"
                   . "<b>📱 Perangkat:</b> {$userAgent}\n"
                   . "<b>🔗 URL:</b> " . $request->fullUrl() . "\n"
                   . "<b>🚨 Pola:</b> " . htmlspecialchars($detectedAttack) . "\n\n"
                   . "<b>📄 Data:</b>\n" . substr(htmlspecialchars($payloadString), 0, 300) . "...\n\n"
                   . "<i>IP ini telah otomatis diblokir secara global.</i>";

            GeneralHelper::sendTelegramMessage($tgMsg);

            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json(['success' => false, 'message' => 'Access Denied: Malicious Request Detected'], 403);
            }
            abort(403, 'Akses ditolak. Server mendeteksi permintaan yang tidak valid atau berbahaya (WAF Protection).');
        }

        return $next($request);
    }
}
