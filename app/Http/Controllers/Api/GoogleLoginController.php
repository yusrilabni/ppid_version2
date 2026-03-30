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
    public function redirectToGoogle()
    {
        return response()->json([
            'url' => Socialite::driver('google')->stateless()->redirect()->getTargetUrl(),
        ]);
    }

    /**
     * Obtain the user information from Google.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to authenticate with Google.'], 400);
        }

        // Check if a user with this google_id already exists
        $user = User::where('google_id', $googleUser->id)->first();

        if (!$user) {
            // If user doesn't exist, check by email
            $user = User::where('email', $googleUser->getEmail())->first();

            if (!$user) {
                // If no user with this email, create a new one
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'google_token' => $googleUser->token,
                    'password' => Hash::make(Str::random(24)), // Generate a random password
                    'nip' => null, // NIP is not required for Google login
                    'role' => 'user', // Default role for new social users
                ]);
            } else {
                // If user exists with this email but not google_id, update their google_id and token
                $user->google_id = $googleUser->getId();
                $user->google_token = $googleUser->token;
                $user->save();
            }
        } else {
            // If user exists with google_id, update their token
            $user->google_token = $googleUser->token;
            $user->save();
        }

        // Generate Sanctum token
        $token = $user->createToken('google-api-token')->plainTextToken;

        if ($user->role === 'superadmin') {
            return redirect('/admin/dashboard');
        }

        return redirect('/?token=' . $token);
    }
}
