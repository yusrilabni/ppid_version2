<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class OptionalSanctumAuth
{
    /**
     * Isi user dari token Sanctum bila ada, tanpa mewajibkan login.
     * Tamu tanpa token tetap lewat sebagai tamu (hanya melihat yang public).
     * Token valid membuat $request->user() terisi sehingga superadmin /
     * admin OPD pemilik melihat jawaban private miliknya.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->bearerToken()) {
            try {
                $user = Auth::guard('sanctum')->user();
                if ($user) {
                    $request->setUserResolver(function () use ($user) {
                        return $user;
                    });
                }
            } catch (\Throwable $e) {
                // Token tidak valid -> perlakukan sebagai tamu, jangan 401.
            }
        }
        return $next($request);
    }
}
