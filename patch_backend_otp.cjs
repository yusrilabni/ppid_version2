const fs = require('fs');

function patch(file) {
  let code = fs.readFileSync(file, 'utf8');

  // 1. Add getWhatsAppNumber helper
  if (!code.includes('private function getWhatsAppNumber')) {
    code = code.replace(
      /    public function requestUnlinkOtp\(Request \$request\)/,
      `    private function getWhatsAppNumber($user)
    {
        if (!$user->nip) return null;
        $apiData = User::getDataFromApi($user->nip);
        $phone = $apiData['nomor_hp'] ?? null;
        if ($phone && $phone !== '-' && $phone !== '') {
            return \\App\\Helpers\\GeneralHelper::formatPhoneNumber($phone);
        }
        return null;
    }

    public function requestUnlinkOtp(Request $request)`
    );
  }

  // 2. Patch requestUnlinkOtp
  const oldUnlinkLogic = `        if (!$user->email || $user->email === '-') {
            return response()->json([
                'success' => false,
                'message' => 'Akun Anda tidak memiliki email yang valid untuk menerima OTP.'
            ], 400);
        }

        $otp = sprintf('%06d', mt_rand(0, 999999));
        $cacheKey = 'unlink_otp_' . $user->id;
        
        $cachedData = [
            'otp' => $otp,
            'expires_at' => now()->addMinutes(1)->timestamp,
            'cooldown_until' => now()->addMinutes(1)->timestamp
        ];
        \\Illuminate\\Support\\Facades\\Cache::put($cacheKey, $cachedData, now()->addMinutes(15));

        $this->sendOtpEmail($user->email, $otp, 'Putuskan Tautan Google', 'memutuskan tautan', 'sistem PPID', $user->name);

        return response()->json([
            'success' => true,
            'message' => 'Kode OTP telah dikirim ke email Anda.'
        ]);`;

  const newUnlinkLogic = `        $emailValid = $user->email && $user->email !== '-';
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
        \\Illuminate\\Support\\Facades\\Cache::put($cacheKey, $cachedData, now()->addMinutes(15));

        $messageTarget = '';
        if ($emailValid) {
            $this->sendOtpEmail($user->email, $otp, 'Putuskan Tautan Google', 'memutuskan tautan', 'sistem PPID', $user->name);
            $messageTarget = 'email Anda';
        } else {
            $waMessage = "*Verifikasi Putuskan Tautan Google*\\n\\nHalo {$user->name},\\nKode Verifikasi (OTP) Keamanan Anda adalah:\\n\\n*{$otp}*\\n\\nKode ini berlaku selama 1 menit.";
            \\App\\Helpers\\GeneralHelper::sendWhatsApp($waNumber, $waMessage);
            $messageTarget = 'WhatsApp Anda (' . substr($waNumber, 0, 6) . 'xxx)';
        }

        return response()->json([
            'success' => true,
            'message' => "Kode OTP telah dikirim ke $messageTarget."
        ]);`;

  // Fix escaping for string replacement
  code = code.replace(/        if \(!\$user->email \|\| \$user->email === '-'\) \{[\s\S]*?'message' => 'Kode OTP telah dikirim ke email Anda\.'\n        \]\);/m, newUnlinkLogic);


  // 3. Patch resendOtp for unlink
  const oldResendUnlink = `            $cachedData['otp'] = $otp;
            $cachedData['expires_at'] = now()->addMinutes(1)->timestamp;
            $cachedData['cooldown_until'] = now()->addMinutes(1)->timestamp;
            
            \\Illuminate\\Support\\Facades\\Cache::put($cacheKey, $cachedData, now()->addMinutes(15));
            $this->sendOtpEmail($user->email, $otp, 'Putuskan Tautan Google', 'memutuskan tautan', 'sistem PPID', $user->name);`;

  const newResendUnlink = `            $cachedData['otp'] = $otp;
            $cachedData['expires_at'] = now()->addMinutes(1)->timestamp;
            $cachedData['cooldown_until'] = now()->addMinutes(1)->timestamp;
            
            \\Illuminate\\Support\\Facades\\Cache::put($cacheKey, $cachedData, now()->addMinutes(15));
            
            $emailValid = $user->email && $user->email !== '-';
            if ($emailValid) {
                $this->sendOtpEmail($user->email, $otp, 'Putuskan Tautan Google', 'memutuskan tautan', 'sistem PPID', $user->name);
            } else if (!empty($cachedData['wa_number'])) {
                $waMessage = "*Verifikasi Putuskan Tautan Google*\\n\\nHalo {$user->name},\\nKode Verifikasi (OTP) Keamanan Anda adalah:\\n\\n*{$otp}*\\n\\nKode ini berlaku selama 1 menit.";
                \\App\\Helpers\\GeneralHelper::sendWhatsApp($cachedData['wa_number'], $waMessage);
            }`;
            
  code = code.replace(oldResendUnlink, newResendUnlink);

  fs.writeFileSync(file, code);
  console.log('Patched ' + file);
}

patch('app/Http/Controllers/Api/GoogleLoginController.php');
