<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Import Controllers
use App\Http\Controllers\Api\OfficialController;
use App\Http\Controllers\Api\InformasiController;
use App\Http\Controllers\Api\LaporanController;
use App\Http\Controllers\Api\PermohonanInformasiController;
use App\Http\Controllers\Api\SliderController;
use App\Http\Controllers\Api\GaleriController;
use App\Http\Controllers\Api\StatistikController;
use App\Http\Controllers\Api\MenuController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\HealthController;

/*
|--------------------------------------------------------------------------
| API Routes V1
|--------------------------------------------------------------------------
*/

Route::prefix('v1')->group(function () {

    // API Paket Lengkap untuk Beranda Android
    Route::get('/home', [App\Http\Controllers\Api\HomeController::class, 'index']);

    // --- PUBLIC ROUTES (Tanpa Login) ---

    // Data Organisasi & Pimpinan (Jantung Metadata Android)
    Route::get('/officials', [OfficialController::class, 'index']);
    Route::get('/officials/{slug}', [OfficialController::class, 'show']);

    // Informasi Publik & Laporan
    Route::get('/informasi', [InformasiController::class, 'index']);
    Route::get('/informasi/{slug}', [InformasiController::class, 'show']);
    Route::get('/laporan', [LaporanController::class, 'index']);

    // Permohonan Informasi (Formulir via Android)
    Route::post('/permohonan', [PermohonanInformasiController::class, 'store']);
    Route::get('/permohonan/status/{code}', [PermohonanInformasiController::class, 'checkStatus']);

    // Visual & Identitas
    Route::get('/sliders', [SliderController::class, 'index']);
    Route::get('/galeri', [GaleriController::class, 'index']);
    Route::get('/menu', [MenuController::class, 'index']);

    // Statistik & Sistem
    Route::get('/statistik', [StatistikController::class, 'index']);
    Route::get('/health', [HealthController::class, 'index']);
    Route::get('/profil', [App\Http\Controllers\Api\ProfilPpidController::class, 'index']);

    // Auth & Kontak
    Route::post('/login', [App\Http\Controllers\Api\LoginController::class, 'login']);
    Route::post('/register', [App\Http\Controllers\Api\RegisterController::class, 'register']);
    Route::post('/contact', [ContactController::class, 'store']);

    // --- PROTECTED ROUTES (Perlu Token Sanctum) ---

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/user', function (Request $request) {
            return $request->user();
        });

        Route::post('/logout', [App\Http\Controllers\Api\LoginController::class, 'logout']);
    });

});

// Fallback rute lama (jika masih ada yang pakai, agar tidak langsung error)
Route::get('/health', [HealthController::class, 'index']);
Route::post('/telegram/webhook', [\App\Http\Controllers\Api\TelegramWebhookController::class, 'handle']);
