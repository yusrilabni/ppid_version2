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

        if ($action === 'login') {
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email Anda belum terdaftar di sistem. Silakan buat akun terlebih dahulu.',
                    'error_type' => 'not_registered'
                ], 403);
            }
            
            // update google_id if missing
            if (!$user->google_id) {
                $user->google_id = $googleUser->getId();
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
            
            // Create new user
            $user = User::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
                'password' => Hash::make(Str::random(24)),
                'role' => 'user',
                'login_type' => 'google',
                'email_verified_at' => now(),
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Aksi tidak valid.'
            ], 400);
        }

        // Generate Sanctum token
        $token = $user->createToken('google-api-token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil',
            'user' => $user,
            'token' => $token
        ]);
    }
}
