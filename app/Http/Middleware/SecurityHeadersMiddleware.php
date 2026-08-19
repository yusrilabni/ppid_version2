<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeadersMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Abaikan jika response berupa BinaryFileResponse (seperti unduh file)
        if (!method_exists($response, 'header')) {
            return $response;
        }

        $response->header('X-Content-Type-Options', 'nosniff');
        $response->header('X-Frame-Options', 'SAMEORIGIN');
        $response->header('X-XSS-Protection', '1; mode=block');
        $response->header('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload');
        $response->header('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->header('Cross-Origin-Opener-Policy', 'same-origin');
        $response->header('Cross-Origin-Resource-Policy', 'same-origin');
        
        // Basic CSP to mitigate XSS (Can be adjusted if it breaks inline scripts like AlpineJS/Livewire)
        // Since Laravel admin often uses inline scripts, we use 'unsafe-inline' but restrict object-src.
        $response->header('Content-Security-Policy', "default-src 'self' https: data: 'unsafe-inline' 'unsafe-eval'; object-src 'none';");

        return $response;
    }
}
