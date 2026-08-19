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

Route::prefix('v1')->middleware('throttle:60,1')->group(function () {

    // API Paket Lengkap untuk Beranda Android
    Route::get('/home', [App\Http\Controllers\Api\HomeController::class, 'index']);
    Route::get('/rss-news', [App\Http\Controllers\Api\HomeController::class, 'rssNews']);

    // --- PUBLIC ROUTES (Tanpa Login) ---

    // Data Organisasi & Pimpinan (Jantung Metadata Android)
    Route::get('/officials', [OfficialController::class, 'index']);
    Route::get('/officials/{slug}', [OfficialController::class, 'show']);

    // Informasi Publik & Laporan
    Route::get('/informasi', [InformasiController::class, 'index']);
    Route::get('/informasi/{slug}', [InformasiController::class, 'show']);
    Route::get('/laporan', [LaporanController::class, 'index']);
    Route::get('/laporan/ppid/file/{token}', [App\Http\Controllers\FrontendController::class, 'serveLaporanFile']);
    
    // Informasi Pemkab
    Route::get('/informasi-pemkab', [App\Http\Controllers\Api\InformasiPemkabController::class, 'index']);
    Route::get('/informasi-pemkab/{slug}', [App\Http\Controllers\Api\InformasiPemkabController::class, 'show']);

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

    // API Endpoint for Standar Layanan
    Route::get('/standar-layanan/file/{subStandarLayanan:slug}', [App\Http\Controllers\Frontend\StandarLayananController::class, 'showFileDetail']);
    Route::get('/standar-layanan/{slug}', [App\Http\Controllers\Frontend\StandarLayananController::class, 'showBySlug']);

    // === NEW: Frontend SPA Routes ===
    
    Route::get('/laporan-permohonan', function (\Illuminate\Http\Request $request) {
        $query = \App\Models\PermohonanInformasi::query()
            ->whereIn('privacy_status', ['Publik', 'Anonim'])
            ->whereIn('status_permohonan', ['selesai', 'ditolak']);

        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('nama_pemohon', 'like', '%' . $searchTerm . '%')
                    ->orWhere('unique_code', 'like', '%' . $searchTerm . '%')
                    ->orWhere('detail_informasi', 'like', '%' . $searchTerm . '%');
            });
        }

        if ($request->has('date_from') && $request->date_from != '') {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->has('date_to') && $request->date_to != '') {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $sort = $request->get('sort', 'created_at_desc');
        switch ($sort) {
            case 'nama_pemohon_asc':
                $query->orderBy('nama_pemohon', 'asc');
                break;
            case 'nama_pemohon_desc':
                $query->orderBy('nama_pemohon', 'desc');
                break;
            case 'created_at_asc':
                $query->orderBy('created_at', 'asc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $perPage = min((int) $request->get('per_page', 10), 100);
        $permohonan = $query->paginate($perPage);

        return response()->json(['success' => true, 'data' => $permohonan]);
    });

    // Survey public listing
    Route::get('/surveys', function () {
        $surveys = \App\Models\Survey::where('status', 'Aktif')
            ->whereIn('type', ['skm', 'ppid'])
            ->select('id', 'title', 'description', 'type', 'slug', 'created_at')
            ->orderBy('created_at', 'desc')
            ->get();
        return response()->json(['success' => true, 'data' => $surveys]);
    });
    
    // Survey single detail and submit
    Route::get('/surveys/{survey:slug}', [App\Http\Controllers\Api\SurveyApiController::class, 'show']);
    Route::post('/surveys/{survey:slug}/submit', [App\Http\Controllers\Api\SurveyApiController::class, 'submit']);

    // LHKPN
    Route::get('/lhkpn', [App\Http\Controllers\Api\LhkpnController::class, 'index']);

    // PBJ
    Route::get('/pbj/years', [App\Http\Controllers\Api\PbjController::class, 'getYears']);
    Route::get('/pbj', [App\Http\Controllers\Api\PbjController::class, 'getQuestions']);

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

    // Global Search (untuk SearchPage Vue) — throttle ketat: maks 10 req/menit per IP
    Route::middleware('throttle:10,1')->get('/global-search', function (\Illuminate\Http\Request $request) {
        $query = $request->get('q', '');
        if (empty($query) || strlen(trim($query)) < 3) {
            return response()->json([
                'success' => true,
                'data' => [
                    'informasi' => ['data' => [], 'links' => [], 'total' => 0],
                    'standarLayanan' => [],
                    'organizations' => []
                ]
            ]);
        }

        $searchTerm = trim($query);
        $searchLower = strtolower($searchTerm);
        $words = array_filter(explode(' ', $searchTerm), function($w) {
            return strlen($w) > 1;
        });

        // 1. Informasi Publik (dengan scoring mirip FrontendController)
        $informasiQuery = \App\Models\Informasi::with(['user', 'organization']);
        $informasiQuery->where(function($q) use ($searchTerm, $words) {
            $q->where('title', 'like', '%' . $searchTerm . '%')
              ->orWhere('deskripsi', 'like', '%' . $searchTerm . '%');
            if (!empty($words)) {
                $q->orWhere(function($subQ) use ($words) {
                    foreach ($words as $word) {
                        $subQ->orWhere('title', 'like', '%' . $word . '%')
                             ->orWhere('deskripsi', 'like', '%' . $word . '%');
                    }
                });
            }
        });

        $allResults = $informasiQuery->limit(200)->get()->map(function($item) use ($searchLower, $words) {
            $titleLower = strtolower($item->title);
            similar_text($titleLower, $searchLower, $percent);
            $score = $percent * 20;

            if ($titleLower === $searchLower) $score += 5000;
            if (str_contains($titleLower, $searchLower)) $score += 1000;
            
            if (!empty($words)) {
                $wordMatches = 0;
                foreach ($words as $word) {
                    if (str_contains($titleLower, $word)) {
                        $wordMatches++;
                        $score += 200;
                    }
                }
                if ($wordMatches === count($words)) {
                    $score += 1000;
                }
            }

            if ($score < 50 && !str_contains($titleLower, $searchLower)) {
                $score -= 1000; 
            }

            $item->search_score = $score;
            return $item;
        })->filter(function($item) {
            return $item->search_score > 0;
        })->sortByDesc('search_score');

        $currentPage = $request->input('page', 1);
        $perPage = 12;
        $currentItems = $allResults->slice(($currentPage - 1) * $perPage, $perPage)->values();
        
        $informasiResults = new \Illuminate\Pagination\LengthAwarePaginator(
            $currentItems,
            $allResults->count(),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        // 2. Standar Layanan (SubStandarLayanan)
        $standarLayananQuery = \App\Models\SubStandarLayanan::with('standarLayanan')->where('title', 'like', '%' . $searchTerm . '%');
        if (!empty($words)) {
            foreach ($words as $word) {
                $standarLayananQuery->orWhere('title', 'like', '%' . $word . '%');
            }
        }
        $standarLayananResults = $standarLayananQuery->take(10)->get();

        // 3. Organizations (Unit/OPD)
        $orgResults = \App\Models\Organization::where('name', 'like', "%{$searchTerm}%")->take(5)->get();

        return response()->json([
            'success' => true,
            'data' => [
                'informasi' => $informasiResults,
                'standarLayanan' => $standarLayananResults,
                'organizations' => $orgResults,
            ]
        ]);
    });

    // --- PROTECTED ROUTES (Perlu Token Sanctum) ---

    Route::middleware('auth:sanctum')->get('/clear-home', function() {
        \Illuminate\Support\Facades\Cache::forget('all_home');
        return response()->json(['success' => true, 'message' => 'Cache cleared!']);
    });

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
Route::middleware('throttle:30,1')->group(function () {
    Route::post('/telegram/webhook', [\App\Http\Controllers\Api\TelegramWebhookController::class, 'handle']);
    Route::match(['get', 'post'], '/whatsapp/webhook', [\App\Http\Controllers\Api\WhatsAppWebhookController::class, 'handle']);
});
