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

        if (!method_exists($response, 'header')) {
            return $response;
        }

        $response->header('X-Content-Type-Options', 'nosniff');
        $response->header('X-XSS-Protection', '1; mode=block');
        $response->header('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload');
        
        // Use Str::contains as a robust fallback for path checking
        if (str_contains($request->url(), 'widgets/embed')) {
            $response->headers->remove('X-Frame-Options');
            $response->header('Cross-Origin-Opener-Policy', 'unsafe-none');
            $response->header('Cross-Origin-Resource-Policy', 'cross-origin');
            $response->header('Content-Security-Policy', "default-src 'self' https: data: 'unsafe-inline' 'unsafe-eval'; frame-ancestors *; object-src 'none';");
        } else {
            $response->header('X-Frame-Options', 'SAMEORIGIN');
            $response->header('Referrer-Policy', 'strict-origin-when-cross-origin');
            $response->header('Cross-Origin-Opener-Policy', 'same-origin');
            $response->header('Cross-Origin-Resource-Policy', 'same-origin');
            $response->header('Content-Security-Policy', "default-src 'self' https: data: 'unsafe-inline' 'unsafe-eval'; object-src 'none';");
        }

        return $response;
    }
}
