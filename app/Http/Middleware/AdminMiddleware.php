<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            Log::warning('AdminMiddleware: User not authenticated.');
            abort(403, 'Unauthorized action.');
        }

        $user = auth()->user();
        Log::info('AdminMiddleware: User authenticated. NIP: ' . $user->nip . ', Role: ' . $user->role);

        if ($user->role !== 'superadmin' && $user->role !== 'admin') {
            \Log::warning('AdminMiddleware: User ' . $user->nip . ' is not an admin or superadmin. Role: ' . $user->role);
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
