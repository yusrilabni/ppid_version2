<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class LoginProtectionController extends Controller
{
    /**
     * Show the login protection verification form
     */
    public function showVerificationForm()
    {
        return view('auth.protection-verify');
    }

    /**
     * Verify the protection password
     */
    public function verify(Request $request)
    {
        $request->validate([
            'protection_password' => 'required|string',
        ]);

        $inputPassword = $request->input('protection_password');
        $configPassword = config('login_protection.protection_password');

        if ($inputPassword === $configPassword) {
            // Set session for protection verification
            $timeout = config('login_protection.session_timeout', 30) * 60; // Convert to seconds
            Session::put('login_protection_verified_until', time() + $timeout);

            // Redirect back to original request
            $intended = Session::get('url.intended', '/');
            return redirect($intended);
        }

        return back()
            ->withInput()
            ->withErrors(['protection_password' => 'Password proteksi tidak valid.']);
    }
}
