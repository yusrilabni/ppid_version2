<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class LoginProtectionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah proteksi login diaktifkan
        if (!config('login_protection.enabled', true)) {
            return $next($request);
        }

        // Hanya proteksi saat belum login dan mencoba akses sistem login
        if (!$this->isUserLoggedIn() && $this->isLoginRelatedRoute($request)) {
            if (!$this->isProtectedAccessVerified()) {
                return redirect()->route('login.protection.verify')
                    ->with('error', 'Akses ke sistem login memerlukan verifikasi tambahan.');
            }
        }

        return $next($request);
    }

    /**
     * Check if the current route is admin or auth related
     */
    private function isAdminOrAuthRoute(Request $request): bool
    {
        $routeName = $request->route() ? $request->route()->getName() : null;
        $uri = $request->path();

        // Hanya proteksi rute login, auth, dan tindakan sensitif tertentu
        // Jangan proteksi semua halaman admin setelah login
        return str_contains($uri, '/login') ||
               str_contains($uri, '/register') ||
               str_contains($uri, '/auth') ||
               (str_contains($uri, '/admin') &&
                (str_contains($uri, '/users') || str_contains($uri, '/officials') || str_contains($uri, '/profile')))
               ;
    }

    /**
     * Check if user is logged in
     */
    private function isUserLoggedIn(): bool
    {
        return Auth::check();
    }

    /**
     * Check if the current route is login related
     */
    private function isLoginRelatedRoute(Request $request): bool
    {
        $uri = $request->path();
        $routeName = $request->route() ? $request->route()->getName() : null;

        // Hanya proteksi rute login, auth, dan register
        return str_contains($uri, '/login') ||
               str_contains($uri, '/register') ||
               str_contains($uri, '/auth') ||
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

        // Jika belum ada verifikasi atau sudah expired
        if (!$verifiedUntil || time() > $verifiedUntil) {
            return false;
        }

        return true;
    }
}
