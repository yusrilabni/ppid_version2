<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes V1
|--------------------------------------------------------------------------
*/

Route::prefix('v1')->group(function () {

    // API Beranda
    Route::get('/home', [\App\Http\Controllers\Api\HomeController::class, 'index']);

    // Public Routes
    Route::get('/officials', [\App\Http\Controllers\Api\OfficialController::class, 'index']);
    Route::get('/officials/{slug}', [\App\Http\Controllers\Api\OfficialController::class, 'show']);

    Route::get('/informasi', [\App\Http\Controllers\Api\InformasiController::class, 'index']);
    Route::get('/laporan', [\App\Http\Controllers\Api\LaporanController::class, 'index']);

    Route::post('/permohonan', [\App\Http\Controllers\Api\PermohonanInformasiController::class, 'store']);
    Route::get('/permohonan/status/{code}', [\App\Http\Controllers\Api\PermohonanInformasiController::class, 'checkStatus']);

    Route::get('/sliders', [\App\Http\Controllers\Api\SliderController::class, 'index']);
    Route::get('/galeri', [\App\Http\Controllers\Api\GaleriController::class, 'index']);
    Route::get('/menu', [\App\Http\Controllers\Api\MenuController::class, 'index']);

    Route::get('/statistik', [\App\Http\Controllers\Api\StatistikController::class, 'index']);
    Route::get('/health', [\App\Http\Controllers\Api\HealthController::class, 'index']);

    Route::post('/login', [\App\Http\Controllers\Api\LoginController::class, 'login']);
    Route::post('/contact', [\App\Http\Controllers\Api\ContactController::class, 'store']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/user', function (Request $request) {
            return $request->user();
        });
        Route::post('/informasi/upload', [\App\Http\Controllers\Api\InformasiController::class, 'store']);
        Route::post('/laporan/upload', [\App\Http\Controllers\Api\LaporanController::class, 'store']);
    });
});

Route::get('/health', [\App\Http\Controllers\Api\HealthController::class, 'index']);
Route::post('/telegram/webhook', [\App\Http\Controllers\Api\TelegramWebhookController::class, 'handle']);
