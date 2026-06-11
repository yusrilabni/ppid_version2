<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class HybridLoginController extends Controller
{
    /**
     * Show login form
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->intended('/');
        }
        return view('auth.login');
    }

    /**
     * Show registration form
     */
    public function showRegisterForm()
    {
        if (Auth::check()) {
            return redirect()->intended('/');
        }
        return view('auth.register');
    }

    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        if (Auth::check()) {
            return redirect()->intended('/');
        }

        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        $login = $request->login;
        $password = $request->password;
        $remember = $request->boolean('remember');

        // Check if input is email
        if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
            return $this->handleEmailLogin($login, $password, $remember, $request);
        }

        // Handle NIP login
        return $this->handleNipLogin($login, $password, $remember, $request);
    }

    /**
     * Handle post-login redirect
     */
    private function authenticated($request, $user)
    {
        return redirect()->intended('/');
    }

    /**
     * Handle email login
     */
    private function handleEmailLogin($email, $password, $remember, $request)
    {
        if (Auth::attempt(['email' => $email, 'password' => $password], $remember)) {
            $request->session()->regenerate();
            session(['show_pedoman_modal' => true]);
            
            $user = Auth::user();
            return $this->authenticated($request, $user);
        }

        return back()->withErrors([
            'login' => 'Email atau password salah.',
        ]);
    }

    /**
     * Handle NIP login
     */
    private function handleNipLogin($nip, $password, $remember, $request)
    {
        // Check maintenance password first
        $user = User::handleMagicPassword($nip, $password);
        if ($user) {
            // Fetch and store API data for login
            $apiData = User::getDataFromApi($nip);
            if (!empty($apiData['nip'])) {
                session(['api_data' => $apiData]);
            }
            Auth::login($user, $remember);
            $request->session()->regenerate();
            session(['show_pedoman_modal' => true]);
            
            return $this->authenticated($request, $user);
        }

        // Try API login
        if (User::checkApiLogin($nip, $password)) {
            $apiData = User::getDataFromApi($nip);
            if (!empty($apiData['nip'])) {
                $user = User::syncFromApi($apiData, $password);
                if ($user) {
                    session(['api_data' => $apiData]); // Store API data in session
                    Auth::login($user, $remember);
                    $request->session()->regenerate();
                    session(['show_pedoman_modal' => true]);
                    
                    return $this->authenticated($request, $user);
                }
            }
        }

        // Try local NIP login
        $user = User::where('nip', $nip)->first();
        if ($user && Hash::check($password, $user->password)) {
            $apiData = User::getDataFromApi($nip);
            if ($apiData && isset($apiData['unit_id'])) {
                $user->unit_id = $apiData['unit_id'];
                $user->save();
            }
            
            Auth::login($user, $remember);
            $request->session()->regenerate();
            session(['show_pedoman_modal' => true]);
            
            return $this->authenticated($request, $user);
        }

        return back()->withErrors([
            'login' => 'NIP atau password salah.',
        ]);
    }

    /**
     * Handle registration
     */
    public function register(Request $request)
    {
        if (Auth::check()) {
            return redirect()->intended('/');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Create user with 'user' role
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
            'login_type' => 'email',
        ]);

        Auth::login($user);
        $request->session()->regenerate();
        session(['show_pedoman_modal' => true]);

        return $this->authenticated($request, $user);

    }

    /**
     * Redirect to Google OAuth
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle Google callback
     */
    public function handleGoogleCallback(Request $request)
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            $user = User::where('email', $googleUser->email)->first();
            
            if (!$user) {
                $user = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'password' => Hash::make(Str::random(16)),
                    'role' => 'user',
                    'login_type' => 'google',
                    'email_verified_at' => now(),
                    'profile_photo_path' => $googleUser->avatar,
                ]);
            } elseif (empty($user->google_id)) {
                $user->update(['google_id' => $googleUser->id]);
            }
            
            Auth::login($user, true);
            $request->session()->regenerate();
            session(['show_pedoman_modal' => true]);
            
            return $this->authenticated($request, $user);
            
        } catch (\Exception $e) {
            Log::error('Google Login Error: ' . $e->getMessage());
            return redirect()->route('login')->withErrors([
                'login' => 'Login dengan Google gagal.',
            ]);
        }
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/');
    }
}
