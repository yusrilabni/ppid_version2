<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnforceNuxtRedirect
{
    public function handle(Request , Closure ): Response
    {
        \ = \->path();

        // 1. Bypass untuk API, Storage, System, dll
        if (\->is('api/*') || \->is('storage/*') || \->is('sanctum/*') || \->is('livewire/*') || \->is('build/*') || \->is('vendor/*') || \->is('assets/*') || \->is('wa-debug*') || \->is('test-*') || \->is('_debugbar/*')) {
            return \(\);
        }

        // 2. Jika secara eksplisit diawali dengan /web atau /web/ (Akses Manual)
        if (\->is('web') || \->is('web/*')) {
            
            // Beri akses session untuk backend
            session(['backend_access_granted' => true]);

            // Dapatkan URI asli (misal: /web/profil atau /v2/web/profil)
            \ = \->server->get('REQUEST_URI');
            
            // Buang kata '/web' dari URI
            // Karena di .htaccess ada rewrite ke /v2/, URI mungkin /v2/web/profil
            \ = preg_replace('#/web(/|$)#', '/', \, 1);
            if (\ === '' || str_starts_with(\, '?')) {
                \ = '/' . \;
            }
            
            // Duplicate request agar Laravel menganggap ini akses normal tanpa /web
            \ = \->duplicate(null, null, null, null, null, ['REQUEST_URI' => \]);

            return \(\);
        }

        // 3. Pengecekan Halaman Backend (/admin, /login)
        \ = \->is('login') 
            || \->is('login/*') 
            || \->is('logout') 
            || \->is('register') 
            || \->is('admin') 
            || \->is('admin/*') 
            || \->is('auth/*');

        if (\) {
            if (session('backend_access_granted')) {
                return \(\);
            }
            return redirect()->to('https://ppid.sinjaikab.go.id', 301);
        }

        // 4. Jika tidak ada /web, REDIRECT KE NUXT!
        if (str_starts_with(\, 'v2/')) {
            \ = substr(\, 3);
        } elseif (\ === 'v2') {
            \ = '';
        }

        if (\ === '/' || \ === '') {
            return redirect()->to('https://ppid.sinjaikab.go.id', 301);
        }

        return redirect()->to('https://ppid.sinjaikab.go.id/' . \, 301);
    }
}
