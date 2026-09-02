<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class GoogleLoginController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function redirectToGoogle(Request $request)
    {
        $action = $request->input('action', 'login');
        
        // HARDCODE UNTUK SPA FLOW
        config(['services.google.redirect' => 'https://ppid.sinjaikab.go.id/google-callback']);

        return Socialite::driver('google')->stateless()->with(['state' => $action])->redirect();
    }

    /**
     * Obtain the user information from Google.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleGoogleCallback(Request $request)
    {
        $frontendUrl = config('app.frontend_url', 'https://ppid.sinjaikab.go.id');
        $action = $request->input('state', 'login');
        
        // HARDCODE UNTUK SPA FLOW
        config(['services.google.redirect' => 'https://ppid.sinjaikab.go.id/google-callback']);
        
        try {
            if (!$request->has('code')) {
                throw new \Exception('EMPTY PARAMS! Redirect URI in config: ' . config('services.google.redirect'));
            }
            $googleUser = Socialite::driver('google')->stateless()->user();
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal autentikasi dengan Google: ' . $e->getMessage()
            ], 400);
        }

        $user = User::where('email', $googleUser->getEmail())->first();

        if ($action === 'link') {
            $currentUser = $request->user('sanctum');
            if (!$currentUser) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sesi berakhir. Anda harus login terlebih dahulu.'
                ], 401);
            }

            // CEK DOUBLE LINK (Mencegah tautan ganda)
            if ($currentUser->google_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Akun Anda sudah tertaut dengan Google. Silakan putuskan tautan terlebih dahulu jika ingin menggunakan akun Google lain.',
                    'error_type' => 'already_linked'
                ], 400);
            }

            // Generate 6 digit OTP
            $otp = sprintf('%06d', mt_rand(0, 999999));
            
            // Simpan data Google ke cache untuk diproses setelah OTP diverifikasi
            $cacheKey = 'link_otp_' . $currentUser->id;
            \Illuminate\Support\Facades\Cache::put($cacheKey, [
                'otp' => $otp,
                'google_id' => $googleUser->getId(),
                'email' => $googleUser->getEmail(),
                'avatar' => $googleUser->getAvatar(),
                'expires_at' => now()->addMinutes(1)->timestamp,
                'cooldown_until' => now()->addMinutes(1)->timestamp
            ], now()->addMinutes(15)); // Simpan 15 menit agar bisa resend tanpa Google auth lagi

            try {
                $this->sendOtpEmail($googleUser->getEmail(), $otp, 'Tautkan Akun Google', 'menautkan', 'Google ini');
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ], 400);
            }

            return response()->json([
                'success' => true,
                'require_otp' => true,
                'message' => 'Kode OTP telah dikirim ke email Google Anda. Silakan masukkan kode untuk memverifikasi tautan.',
                'email' => $googleUser->getEmail()
            ]);
        } else if ($action === 'login') {
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email Anda belum terdaftar di sistem. Silakan buat akun terlebih dahulu.',
                    'error_type' => 'not_registered'
                ], 403);
            }
            
            $needsSave = false;
            if (!$user->google_id) {
                $user->google_id = $googleUser->getId();
                $needsSave = true;
            }
            if (empty($user->profile_photo_path) && $googleUser->getAvatar()) {
                $user->profile_photo_path = $googleUser->getAvatar();
                $needsSave = true;
            }
            if ($needsSave) {
                $user->save();
            }
        } else if ($action === 'register') {
            if ($user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email Anda sudah terdaftar. Silakan login.',
                    'error_type' => 'already_registered'
                ], 403);
            }
            
            // Generate 6 digit OTP for registration
            $otp = sprintf('%06d', mt_rand(0, 999999));
            
            // Simpan data pendaftaran sementara ke cache
            $cacheKey = 'register_otp_' . $googleUser->getEmail();
            \Illuminate\Support\Facades\Cache::put($cacheKey, [
                'otp' => $otp,
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
                'avatar' => $googleUser->getAvatar(),
                'expires_at' => now()->addMinutes(1)->timestamp,
                'cooldown_until' => now()->addMinutes(1)->timestamp
            ], now()->addMinutes(15));

            try {
                $this->sendOtpEmail($googleUser->getEmail(), $otp, 'Pendaftaran Akun', 'mendaftar di', 'akun Google ini', $googleUser->getName());
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ], 400);
            }

            return response()->json([
                'success' => true,
                'require_otp' => true,
                'action' => 'register',
                'message' => 'Kode OTP telah dikirim ke email Google Anda. Silakan masukkan kode untuk memverifikasi pendaftaran.',
                'email' => $googleUser->getEmail()
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Aksi tidak valid.'
            ], 400);
        }

        // Generate Sanctum token
        $user->last_login_at = now();
        $user->last_login_ip = request()->ip();
        $user->save();
        $token = $user->createToken('google-api-token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Autentikasi berhasil',
            'user' => $user,
            'token' => $token
        ]);
    }

    private function sendOtpEmail($toEmail, $otp, $title, $actionWord, $targetWord, $name = 'Pengguna')
    {
        try {
            $htmlBody = "
            <div style='font-family: Arial, sans-serif; max-width: 500px; margin: auto; padding: 20px; border: 1px solid #eaeaea; border-radius: 10px;'>
                <h2 style='color: #2563eb; text-align: center;'>Verifikasi $title</h2>
                <p>Halo " . htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . ",</p>
                <p>Anda menerima email ini karena ada permintaan untuk <strong>$actionWord</strong> sistem PPID Kabupaten Sinjai menggunakan $targetWord.</p>
                <p>Kode Verifikasi (OTP) Keamanan Anda adalah:</p>
                <div style='text-align: center; margin: 30px 0;'>
                    <span style='font-size: 32px; font-weight: bold; letter-spacing: 5px; color: #1e40af; padding: 10px 20px; background-color: #eff6ff; border-radius: 8px;'>$otp</span>
                </div>
                <p style='color: #666; font-size: 14px;'>Kode ini berlaku selama 1 menit. Jika Anda tidak merasa melakukan permintaan ini, abaikan email ini.</p>
                <hr style='border: none; border-top: 1px solid #eaeaea; margin: 30px 0;'>
                <p style='color: #999; font-size: 12px; text-align: center;'>&copy; " . date('Y') . " PPID Kabupaten Sinjai</p>
            </div>
            ";

            $apiKey = env('BREVO_API_KEY');
            
            if (!$apiKey) {
                throw new \Exception('API Key Brevo tidak dikonfigurasi (BREVO_API_KEY).');
            }
            
            $response = \Illuminate\Support\Facades\Http::withHeaders([
                'api-key' => $apiKey,
                'Content-Type' => 'application/json',
            ])->post('https://api.brevo.com/v3/smtp/email', [
                'sender' => [
                    'name' => 'PPID Kabupaten Sinjai',
                    'email' => 'noreply@ppidkab.sinjaikab.go.id'
                ],
                'to' => [
                    [
                        'email' => $toEmail,
                        'name' => $name
                    ]
                ],
                'subject' => "Kode OTP $title: $otp (" . date('H:i:s') . ")",
                'htmlContent' => $htmlBody
            ]);

            if (!$response->successful()) {
                throw new \Exception('Brevo API Error: ' . $response->body());
            }

            return true;
        } catch (\Exception $e) {
            \Log::error('Failed to send OTP email via Brevo API: ' . $e->getMessage());
            throw new \Exception('Gagal mengirim email OTP: ' . $e->getMessage());
        }
    }

    /**
     * Resend OTP for Link, Unlink, and Register
     */
    public function resendOtp(Request $request)
    {
        $request->validate([
            'action' => 'required|in:register,link,unlink',
            'email' => 'required_if:action,register|email'
        ]);

        $action = $request->action;
        $otp = sprintf('%06d', mt_rand(0, 999999));
        
        if ($action === 'register') {
            $email = $request->email;
            $cacheKey = 'register_otp_' . $email;
            $cachedData = \Illuminate\Support\Facades\Cache::get($cacheKey);

            if (!$cachedData) {
                return response()->json(['success' => false, 'message' => 'Sesi pendaftaran kadaluarsa. Silakan kembali mendaftar dari awal via Google.'], 400);
            }

            if (isset($cachedData['cooldown_until']) && now()->timestamp < $cachedData['cooldown_until']) {
                $wait = $cachedData['cooldown_until'] - now()->timestamp;
                return response()->json(['success' => false, 'message' => "Tunggu $wait detik sebelum meminta OTP lagi."], 429);
            }

            $cachedData['otp'] = $otp;
            $cachedData['expires_at'] = now()->addMinutes(1)->timestamp;
            $cachedData['cooldown_until'] = now()->addMinutes(1)->timestamp;
            
            \Illuminate\Support\Facades\Cache::put($cacheKey, $cachedData, now()->addMinutes(15));
            $this->sendOtpEmail($cachedData['email'], $otp, 'Pendaftaran Akun', 'mendaftar di', 'akun Google ini', $cachedData['name'] ?? 'Pengguna');

        } else if ($action === 'link') {
            $user = $request->user();
            if (!$user) return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);

            $cacheKey = 'link_otp_' . $user->id;
            $cachedData = \Illuminate\Support\Facades\Cache::get($cacheKey);

            if (!$cachedData) {
                return response()->json(['success' => false, 'message' => 'Sesi tautan kadaluarsa. Silakan ulangi proses dari awal.'], 400);
            }

            if (isset($cachedData['cooldown_until']) && now()->timestamp < $cachedData['cooldown_until']) {
                $wait = $cachedData['cooldown_until'] - now()->timestamp;
                return response()->json(['success' => false, 'message' => "Tunggu $wait detik sebelum meminta OTP lagi."], 429);
            }

            $cachedData['otp'] = $otp;
            $cachedData['expires_at'] = now()->addMinutes(1)->timestamp;
            $cachedData['cooldown_until'] = now()->addMinutes(1)->timestamp;
            
            \Illuminate\Support\Facades\Cache::put($cacheKey, $cachedData, now()->addMinutes(15));
            $this->sendOtpEmail($cachedData['email'], $otp, 'Tautkan Akun Google', 'menautkan', 'Google ini');

        } else if ($action === 'unlink') {
            $user = $request->user();
            if (!$user) return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);

            $cacheKey = 'unlink_otp_' . $user->id;
            $cachedData = \Illuminate\Support\Facades\Cache::get($cacheKey);

            // Jika cache unlink tidak ada, kita bisa generate baru (karena unlink hanya butuh email user saat ini, bukan email google)
            if (!$cachedData || !is_array($cachedData)) {
                return $this->requestUnlinkOtp($request);
            }

            if (isset($cachedData['cooldown_until']) && now()->timestamp < $cachedData['cooldown_until']) {
                $wait = $cachedData['cooldown_until'] - now()->timestamp;
                return response()->json(['success' => false, 'message' => "Tunggu $wait detik sebelum meminta OTP lagi."], 429);
            }

            $cachedData['otp'] = $otp;
            $cachedData['expires_at'] = now()->addMinutes(1)->timestamp;
            $cachedData['cooldown_until'] = now()->addMinutes(1)->timestamp;
            
            \Illuminate\Support\Facades\Cache::put($cacheKey, $cachedData, now()->addMinutes(15));
            
            $emailValid = $user->email && $user->email !== '-';
            if ($emailValid) {
                $this->sendOtpEmail($user->email, $otp, 'Putuskan Tautan Google', 'memutuskan tautan', 'sistem PPID', $user->name);
            } else if (!empty($cachedData['wa_number'])) {
                $waMessage = "*Verifikasi Putuskan Tautan Google*\n\nHalo {$user->name},\nKode Verifikasi (OTP) Keamanan Anda adalah:\n\n*{$otp}*\n\nKode ini berlaku selama 1 menit.";
                \App\Helpers\GeneralHelper::sendWhatsApp($cachedData['wa_number'], $waMessage);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Kode OTP baru telah berhasil dikirim ke email Anda.'
        ]);
    }

    /**
     * Verify OTP and Link Google Account
     */
    public function verifyLinkOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|string|size:6'
        ]);

        $currentUser = $request->user();
        $cacheKey = 'link_otp_' . $currentUser->id;
        $cachedData = \Illuminate\Support\Facades\Cache::get($cacheKey);

        if (!$cachedData) {
            return response()->json(['success' => false, 'message' => 'Sesi OTP kadaluarsa. Silakan ulangi.'], 400);
        }

        if (isset($cachedData['expires_at']) && now()->timestamp > $cachedData['expires_at']) {
            return response()->json(['success' => false, 'message' => 'Kode OTP sudah kadaluarsa (lewat 1 menit). Silakan klik Kirim Ulang OTP.'], 400);
        }

        if ($cachedData['otp'] !== $request->otp) {
            return response()->json(['success' => false, 'message' => 'Kode OTP salah.'], 400);
        }

        $googleId = $cachedData['google_id'];
        $googleEmail = $cachedData['email'];
        $user = User::where('email', $googleEmail)->first();

        $updateData = [
            'google_id' => $googleId,
            'email' => $googleEmail
        ];
        if (!empty($cachedData['avatar'])) {
            $updateData['profile_photo_path'] = $cachedData['avatar'];
        }

        if ($user && $user->id !== $currentUser->id) {
            // Merge logic
            $roles = [$currentUser->role, $user->role];
            if (in_array('user', $roles) && (in_array('admin', $roles) || in_array('superadmin', $roles))) {
                if ($user->role === 'superadmin' || ($user->role === 'admin' && $currentUser->role === 'user')) {
                    $keptUser = clone $user;
                    $deletedUser = clone $currentUser;
                } else {
                    $keptUser = clone $currentUser;
                    $deletedUser = clone $user;
                }
                
                $updateData['nip'] = $keptUser->nip ?: $deletedUser->nip;
                User::where('id', $keptUser->id)->update($updateData);
                \App\Models\PermohonanInformasi::where('user_id', $deletedUser->id)->update(['user_id' => $keptUser->id]);
                User::where('id', $deletedUser->id)->delete();
                $user = User::find($keptUser->id);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => "Tidak bisa menautkan. Email Google ini sudah terdaftar sebagai {$user->role}."
                ], 403);
            }
        } else {
            // Normal Link
            User::where('id', $currentUser->id)->update($updateData);
            $user = User::find($currentUser->id);
        }

        \Illuminate\Support\Facades\Cache::forget($cacheKey);

        if (method_exists($user, 'tokens')) {
            $user->tokens()->delete();
        }
        $user->last_login_at = now();
        $user->last_login_ip = request()->ip();
        $user->save();
        $token = $user->createToken('google-api-token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Akun berhasil ditautkan dengan Google.',
            'user' => $user,
            'token' => $token
        ]);
    }

    /**
     * Request OTP to unlink Google account
     */
    private function getWhatsAppNumber($user)
    {
        if (!$user->nip) return null;
        $apiData = User::getDataFromApi($user->nip);
        $phone = $apiData['nomor_hp'] ?? null;
        if ($phone && $phone !== '-' && $phone !== '') {
            return \App\Helpers\GeneralHelper::formatPhoneNumber($phone);
        }
        return null;
    }

    public function requestUnlinkOtp(Request $request)
    {
        $user = $request->user();

        if (!$user || !$user->google_id) {
            return response()->json([
                'success' => false,
                'message' => 'Akun belum ditautkan dengan Google.'
            ], 400);
        }

        $emailValid = $user->email && $user->email !== '-';
        $waNumber = $this->getWhatsAppNumber($user);

        if (!$emailValid && !$waNumber) {
            return response()->json([
                'success' => false,
                'message' => 'Akun Anda tidak memiliki email atau nomor HP yang valid untuk menerima OTP.'
            ], 400);
        }

        $otp = sprintf('%06d', mt_rand(0, 999999));
        $cacheKey = 'unlink_otp_' . $user->id;
        
        $cachedData = [
            'otp' => $otp,
            'expires_at' => now()->addMinutes(1)->timestamp,
            'cooldown_until' => now()->addMinutes(1)->timestamp,
            'email' => $user->email,
            'wa_number' => $waNumber
        ];
        \Illuminate\Support\Facades\Cache::put($cacheKey, $cachedData, now()->addMinutes(15));

        $messageTarget = '';
        if ($emailValid) {
            $this->sendOtpEmail($user->email, $otp, 'Putuskan Tautan Google', 'memutuskan tautan', 'sistem PPID', $user->name);
            $messageTarget = 'email Anda';
        } else {
            $waMessage = "*Verifikasi Putuskan Tautan Google*\n\nHalo {$user->name},\nKode Verifikasi (OTP) Keamanan Anda adalah:\n\n*{$otp}*\n\nKode ini berlaku selama 1 menit.";
            \App\Helpers\GeneralHelper::sendWhatsApp($waNumber, $waMessage);
            $messageTarget = 'WhatsApp Anda (' . substr($waNumber, 0, 6) . 'xxx)';
        }

        return response()->json([
            'success' => true,
            'message' => "Kode OTP telah dikirim ke $messageTarget."
        ]);
    }

    /**
     * Verify OTP and unlink Google account
     */
    public function verifyUnlinkOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|string|size:6'
        ]);

        $user = $request->user();
        $cacheKey = 'unlink_otp_' . $user->id;
        $cachedData = \Illuminate\Support\Facades\Cache::get($cacheKey);

        if (!$cachedData || !is_array($cachedData)) {
            return response()->json(['success' => false, 'message' => 'Kode OTP tidak ditemukan atau sesi kadaluarsa.'], 400);
        }

        if (isset($cachedData['expires_at']) && now()->timestamp > $cachedData['expires_at']) {
            return response()->json(['success' => false, 'message' => 'Kode OTP sudah kadaluarsa (lewat 1 menit). Silakan klik Kirim Ulang OTP.'], 400);
        }

        if ($cachedData['otp'] !== $request->otp) {
            return response()->json(['success' => false, 'message' => 'Kode OTP salah.'], 400);
        }

        // OTP Valid! Unlink google
        $user->google_id = null;
        $user->email = '-'; // Hapus juga emailnya agar bersih dari database
        $user->save();

        \Illuminate\Support\Facades\Cache::forget($cacheKey);

        return response()->json([
            'success' => true,
            'message' => 'Tautan akun Google berhasil diputus dan data email telah dihapus.',
            'user' => $user
        ]);
    }

    /**
     * Verify OTP and Create User for Google Registration
     */
    public function verifyRegisterOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|string|size:6'
        ]);

        $cacheKey = 'register_otp_' . $request->email;
        $cachedData = \Illuminate\Support\Facades\Cache::get($cacheKey);

        if (!$cachedData) {
            return response()->json(['success' => false, 'message' => 'Sesi OTP tidak ditemukan atau sudah sangat kadaluarsa.'], 400);
        }

        if (isset($cachedData['expires_at']) && now()->timestamp > $cachedData['expires_at']) {
            return response()->json(['success' => false, 'message' => 'Kode OTP sudah kadaluarsa (lewat 1 menit). Silakan klik Kirim Ulang OTP.'], 400);
        }

        if ($cachedData['otp'] !== $request->otp) {
            return response()->json(['success' => false, 'message' => 'Kode OTP salah.'], 400);
        }

        if (User::where('email', $cachedData['email'])->exists()) {
            return response()->json(['success' => false, 'message' => 'Email sudah terdaftar. Silakan login.'], 400);
        }

        // OTP Valid! Create user
        $createData = [
            'name' => $cachedData['name'],
            'email' => $cachedData['email'],
            'google_id' => $cachedData['google_id'],
            'password' => Hash::make(Str::random(24)),
            'role' => 'user',
            'login_type' => 'google',
            'email_verified_at' => now(),
        ];
        
        if (!empty($cachedData['avatar'])) {
            $createData['profile_photo_path'] = $cachedData['avatar'];
        }
        
        $user = User::create($createData);

        \Illuminate\Support\Facades\Cache::forget($cacheKey);

        $token = $user->createToken('google-api-token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Pendaftaran berhasil. Selamat datang di PPID Sinjai.',
            'user' => $user,
            'token' => $token
        ]);
    }
}
