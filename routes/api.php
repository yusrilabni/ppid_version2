<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Import Controllers
use App\Http\Controllers\Api\ProfilController;
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
    Route::get('/units', [App\Http\Controllers\Api\DinasController::class, 'list']);

    // Statistik & Sistem
    Route::get('/statistik', [StatistikController::class, 'index']);
    Route::get('/health', [HealthController::class, 'index']);
    Route::get('/profil', [App\Http\Controllers\Api\ProfilPpidController::class, 'index']);

    // Auth & Kontak
    Route::post('/login', [App\Http\Controllers\Api\LoginController::class, 'login']);
    Route::post('/register', [App\Http\Controllers\Api\RegisterController::class, 'register']);
    Route::post('/contact', [ContactController::class, 'store']);

    // Profil Routes (for frontend client matching blade UI)
    Route::get('/profil/pejabat-daerah', [ProfilController::class, 'listKepalaOpd']);
    Route::get('/profil/tentang-opd', [ProfilController::class, 'opdList']);
    Route::get('/profil/tentang-opd/{slug}', [ProfilController::class, 'opdDetail']);
    Route::get('/profil/unit-lokal', [ProfilController::class, 'unitLokalList']);
    Route::get('/profil/{slug}', [ProfilController::class, 'showOfficial']);

    // API Endpoint for DIP Unit
    Route::get('/dipunit', [App\Http\Controllers\Api\DinasController::class, 'index']);
    Route::get('/dipunit/dip/{organization:slug}', [App\Http\Controllers\Api\DinasController::class, 'opdDip']);

    // API Endpoint for Global DIP
    Route::get('/dip', [App\Http\Controllers\Frontend\DIPController::class, 'index']);
    Route::get('/dip/{year}', [App\Http\Controllers\Frontend\DIPController::class, 'show']);

    // === NEW: Frontend SPA Routes ===
    
    // Survey public listing
    Route::get('/surveys', function () {
        $surveys = \App\Models\Survey::where('is_active', true)
            ->select('id', 'title', 'description', 'created_at')
            ->orderBy('created_at', 'desc')
            ->get();
        return response()->json(['success' => true, 'data' => $surveys]);
    });

    // Standar Layanan
    Route::get('/standar-layanan', function () {
        $items = \App\Models\StandarLayanan::with('subStandarLayanans')
            ->orderBy('created_at', 'desc')
            ->get();
        return response()->json(['success' => true, 'data' => $items]);
    });

    Route::get('/standar-layanan/{id}', function ($id) {
        $item = \App\Models\StandarLayanan::with(['subStandarLayanans.informasi'])->findOrFail($id);
        return response()->json(['success' => true, 'data' => $item]);
    });

    // Regulasi
    Route::get('/regulasi', function () {
        $items = \App\Models\Regulasi::orderBy('created_at', 'desc')->get();
        return response()->json(['success' => true, 'data' => $items]);
    });

    // SOP
    Route::get('/sop', function () {
        $items = \App\Models\Sop::orderBy('created_at', 'desc')->get();
        return response()->json(['success' => true, 'data' => $items]);
    });

    // Maklumat Layanan
    Route::get('/maklumat-layanan', function () {
        $item = \App\Models\MaklumatLayanan::first();
        return response()->json(['success' => true, 'data' => $item]);
    });

    // Search
    Route::get('/search', function (\Illuminate\Http\Request $request) {
        $query = $request->get('q', '');
        $page = $request->get('page', 1);
        $items = \App\Models\Informasi::where('title', 'like', "%{$query}%")
            ->orWhere('ringkasan', 'like', "%{$query}%")
            ->where('status', 'AKTIF')
            ->with('organization')
            ->orderBy('created_at', 'desc')
            ->paginate(12);
        return response()->json(['success' => true, 'data' => $items]);
    });

    // --- PROTECTED ROUTES (Perlu Token Sanctum) ---

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/user', function (Request $request) {
            return $request->user();
        });

        // Profile Management
        Route::get('/profile', [App\Http\Controllers\Api\ProfileController::class, 'show']);
        Route::post('/profile', [App\Http\Controllers\Api\ProfileController::class, 'update']);

        // My Information Requests (Mobile Tracking)
        Route::get('/my-requests', [PermohonanInformasiController::class, 'myRequests']);
        Route::get('/my-requests/{id}', [PermohonanInformasiController::class, 'show']);
        Route::post('/my-requests/{id}', [PermohonanInformasiController::class, 'update']); // Use POST as proxy for update due to common mobile fetch limitations

        Route::post('/logout', [App\Http\Controllers\Api\LoginController::class, 'logout']);
    });

});

// Fallback rute lama (jika masih ada yang pakai, agar tidak langsung error)
Route::get('/health', [HealthController::class, 'index']);
Route::post('/telegram/webhook', [\App\Http\Controllers\Api\TelegramWebhookController::class, 'handle']);
Route::match(['get', 'post'], '/whatsapp/webhook', [\App\Http\Controllers\Api\WhatsAppWebhookController::class, 'handle']);
