<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->validateCsrfTokens(except: [
            'informasi-crud/check-similarity',
            'api/telegram/webhook',
            'api/whatsapp/webhook'
        ]);
        $middleware->append(\App\Http\Middleware\LoginProtectionMiddleware::class);
        $middleware->append(\Illuminate\Http\Middleware\HandleCors::class);

        $middleware->alias([
            'superadmin' => \App\Http\Middleware\SuperadminMiddleware::class,
            'check.pbj.access' => \App\Http\Middleware\CheckPbjAccess::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Tangkap HttpException dengan status 419 (Page Expired)
        $exceptions->render(function (\Symfony\Component\HttpKernel\Exception\HttpException $e, $request) {
            if ($e->getStatusCode() === 419) {
                return redirect('/');
            }
        });

        // Tangkap TokenMismatchException secara langsung jika belum dikonversi
        $exceptions->render(function (\Illuminate\Session\TokenMismatchException $e, $request) {
            return redirect('/');
        });

        // Tangkap PostTooLargeException agar tidak menampilkan error 500
        $exceptions->render(function (\Illuminate\Http\Exceptions\PostTooLargeException $e, $request) {
            return redirect()->back()->withInput()->with('error', 'Ukuran file atau data yang diunggah terlalu besar. Harap unggah file yang lebih kecil sesuai batas maksimal server.');
        });
    })->create();
