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
        $action = $request->query('action', 'login'); // 'login' or 'register'
        
        return Socialite::driver('google')->stateless()->with(['state' => $action])->redirect();
    }

    /**
     * Obtain the user information from Google.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleGoogleCallback(Request $request)
    {
        $action = $request->input('state', 'login');
        
        try {
            if (!$request->has('code')) {
                throw new \Exception('EMPTY PARAMS! URL: ' . $request->fullUrl() . ' | IP: ' . $request->ip() . ' | Headers: ' . json_encode($request->headers->all()));
            }
            $googleUser = Socialite::driver('google')->stateless()->user();
        } catch (\Exception $e) {
            return redirect(config('app.frontend_url', 'https://ppid.sinjaikab.go.id') . '/login?error=auth_failed&msg=' . urlencode($e->getMessage()));
        }

        $frontendUrl = config('app.frontend_url', 'https://ppid.sinjaikab.go.id');

        $user = User::where('email', $googleUser->getEmail())->first();

        if ($action === 'login') {
            if (!$user) {
                // strict: must be registered first
                return redirect($frontendUrl . '/login?error=not_registered');
            }
            
            // update google_id if missing
            if (!$user->google_id) {
                $user->google_id = $googleUser->getId();
                $user->save();
            }
        } else if ($action === 'register') {
            if ($user) {
                // strict: already registered
                return redirect($frontendUrl . '/register?error=already_registered');
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
            return redirect($frontendUrl . '/login?error=invalid_action');
        }

        // Generate Sanctum token
        $token = $user->createToken('google-api-token')->plainTextToken;

        return redirect($frontendUrl . '/auth/callback?token=' . $token);
    }
}
