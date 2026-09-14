<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnforceNuxtRedirect
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $path = $request->path();

        // 1. Bypass untuk API, Storage, System, dan Webhook
        if ($request->is('api/*') || $request->is('storage/*') || $request->is('sanctum/*') || $request->is('livewire/*') || $request->is('build/*') || $request->is('vendor/*') || $request->is('assets/*') || $request->is('wa-debug*') || $request->is('test-*') || $request->is('_debugbar/*')) {
            return $next($request);
        }

        // 2. Secret Door untuk masuk ke Backend
        if ($request->is('web')) {
            // Set session agar komputer ini dikenali sebagai admin/pengelola
            session(['backend_access_granted' => true]);
            return redirect()->route('login');
        }

        // Daftar awalan route backend yang diizinkan (jika punya akses)
        $isBackendRoute = $request->is('login') 
            || $request->is('login/*') 
            || $request->is('logout') 
            || $request->is('register') 
            || $request->is('admin') 
            || $request->is('admin/*') 
            || $request->is('auth/*');

        // 3. Jika mengakses halaman backend
        if ($isBackendRoute) {
            if (session('backend_access_granted')) {
                return $next($request);
            }
            // Jika tidak punya sesi rahasia, lempar ke beranda Nuxt
            return redirect()->to('https://ppid.sinjaikab.go.id', 301);
        }

        // 4. Jika bukan halaman backend (alias halaman frontend lama seperti profil, v2, dll)
        // Hilangkan prefix v2/ jika ada
        if (str_starts_with($path, 'v2/')) {
            $path = substr($path, 3);
        } elseif ($path === 'v2') {
            $path = '';
        }

        // Redirect full ke Nuxt
        if ($path === '/' || $path === '') {
            return redirect()->to('https://ppid.sinjaikab.go.id', 301);
        }

        return redirect()->to('https://ppid.sinjaikab.go.id/' . $path, 301);
    }
}
