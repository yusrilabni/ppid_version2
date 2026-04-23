<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class LoginProtectionMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Jika user SUDAH LOGIN, lewati semua proteksi ini.
        // Ini adalah kunci agar Admin/Superadmin tidak terkena 403 saat upload.
        if (Auth::check()) {
            return $next($request);
        }

        // 2. Cek apakah proteksi login diaktifkan (Hanya untuk yang BELUM LOGIN)
        if (!config('login_protection.enabled', true)) {
            return $next($request);
        }

        // 3. Hanya proteksi saat mencoba akses sistem login/register
        if ($this->isLoginRelatedRoute($request)) {
            if (!$this->isProtectedAccessVerified()) {
                Log::warning('LoginProtection: Unverified access attempt to login routes.');
                return redirect()->route('login.protection.verify')
                    ->with('error', 'Akses ke sistem login memerlukan verifikasi tambahan.');
            }
        }

        return $next($request);
    }

    /**
     * Check if the current route is login related
     */
    private function isLoginRelatedRoute(Request $request): bool
    {
        $uri = $request->path();
        $routeName = $request->route() ? $request->route()->getName() : null;

        return str_contains($uri, 'login') ||
               str_contains($uri, 'register') ||
               str_contains($uri, 'auth') ||
               ($routeName && in_array($routeName, [
                   'login', 'register', 'auth.google', 'auth.google.callback'
               ]));
    }

    /**
     * Check if protected access is verified
     */
    private function isProtectedAccessVerified(): bool
    {
        $verifiedUntil = Session::get('login_protection_verified_until');
        return $verifiedUntil && time() < $verifiedUntil;
    }
}
