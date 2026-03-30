<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        using: function (Illuminate\Routing\Router $router) {
            // Explicitly define the API login route outside the 'api' middleware group for debugging 419 error.
            \Illuminate\Support\Facades\Route::post('/api/login', [\App\Http\Controllers\Api\LoginController::class, 'login']);

            $router->middleware('web')
                   ->group(base_path('routes/admin.php'));

            $router->middleware('web')
                   ->group(base_path('routes/web.php'));

            $router->middleware('api')
                   ->prefix('api')
                   ->group(base_path('routes/api.php'));
        },
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->validateCsrfTokens(except: [
            'informasi-crud/check-similarity'
        ]);
        $middleware->append(\App\Http\Middleware\LoginProtectionMiddleware::class);

        $middleware->alias([
            'superadmin' => \App\Http\Middleware\SuperadminMiddleware::class,
            'check.pbj.access' => \App\Http\Middleware\CheckPbjAccess::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
