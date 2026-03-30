<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\HealthController;
use App\Http\Controllers\Api\BeritaController;
use App\Http\Controllers\Api\SliderController;
use App\Http\Controllers\Api\GaleriController;
use App\Http\Controllers\Api\InformasiController;
use App\Http\Controllers\Api\LaporanController;
use App\Http\Controllers\Api\StatistikController;
use App\Http\Controllers\Api\MenuController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\LinkAccessLogController;
use App\Http\Controllers\Api\GoogleLoginController;
use App\Http\Controllers\Api\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\OrganizationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Location Search Route
Route::get('/locations', [OrganizationController::class, 'search'])->name('api.locations.search');

// Google Login Routes
Route::get('auth/google', [GoogleLoginController::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [GoogleLoginController::class, 'handleGoogleCallback']);


// Admin routes group
Route::middleware(['auth:sanctum', 'superadmin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index']);
});

Route::get('/health', [HealthController::class, 'index']);

Route::get('/berita', [BeritaController::class, 'index']);
Route::post('/berita', [BeritaController::class, 'store']);

Route::get('/sliders', [SliderController::class, 'index']);
Route::post('/sliders', [SliderController::class, 'store']);

Route::get('/galeri', [GaleriController::class, 'index']);
Route::post('/galeri', [GaleriController::class, 'store']);

Route::get('/informasi', [InformasiController::class, 'index']);
Route::post('/informasi', [InformasiController::class, 'store']);

Route::get('/laporan', [LaporanController::class, 'index']);
Route::post('/laporan', [LaporanController::class, 'store']);

Route::get('/statistik', [StatistikController::class, 'index']);
Route::post('/statistik', [StatistikController::class, 'store']);

Route::get('/menu', [MenuController::class, 'index']);
Route::post('/menu', [MenuController::class, 'store']);

Route::get('/contact', [ContactController::class, 'index']);
Route::post('/contact', [ContactController::class, 'store']);

Route::post('/login', [LoginController::class, 'login']);

Route::post('/log-link-access', [LinkAccessLogController::class, 'logAccess']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});