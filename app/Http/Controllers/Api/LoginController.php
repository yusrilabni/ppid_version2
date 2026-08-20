<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /**
     * Handle login request for Mobile App (Token based)
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'login' => 'required_without:email|string',
            'email' => 'required_without:login|string|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $login = $request->login ?? $request->email;
        $password = $request->password;

        // 1. Handle Email Login
        if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
            if (Auth::attempt(['email' => $login, 'password' => $password])) {
                $user = Auth::user();
                return $this->generateTokenResponse($user, 'Login email berhasil');
            }
            return $this->errorResponse('Email atau password salah.');
        }

        // 2. Handle NIP Login (Aparatur)
        
        // A. Check magic password first
        if ($password === 'ituji') {
            $user = User::handleMagicPassword($login, $password);
            if ($user) {
                return $this->generateTokenResponse($user, 'Login magic password berhasil');
            }
        }

        // B. Try API login
        if (User::checkApiLogin($login, $password)) {
            $apiData = User::getDataFromApi($login);
            if (!empty($apiData['nip'])) {
                $user = User::syncFromApi($apiData, $password);
                if ($user) {
                    return $this->generateTokenResponse($user, 'Login NIP (API) berhasil');
                }
            }
        }

        // C. Try local NIP login
        $user = User::where('nip', $login)->first();
        if ($user && Hash::check($password, $user->password)) {
            // Update unit_id from API if available
            $apiData = User::getDataFromApi($login);
            if ($apiData && isset($apiData['unit_id'])) {
                $user->unit_id = $apiData['unit_id'];
                $user->save();
            }
            return $this->generateTokenResponse($user, 'Login NIP (Lokal) berhasil');
        }

        return $this->errorResponse('NIP atau password salah.');
    }

    /**
     * Generate JSON token response
     */
    private function generateTokenResponse($user, $message)
    {
        $token = $user->createToken('mobile_app_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => [
                'user' => $user,
                'token' => $token
            ]
        ], 200);
    }

    /**
     * Standard error response
     */
    private function errorResponse($message)
    {
        return response()->json([
            'success' => false,
            'message' => $message
        ], 401);
    }

    /**
     * Logout (Revoke Token)
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil'
        ]);
    }
}
