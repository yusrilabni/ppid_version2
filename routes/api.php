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
    Route::get('/informasi', [InformasiController::class, 'index'])->middleware('optional.sanctum');
    Route::get('/informasi/{slug}', [InformasiController::class, 'show'])->middleware('optional.sanctum');
    Route::get('/laporan', [LaporanController::class, 'index']);
    Route::get('/laporan/ppid/file/{token}', [App\Http\Controllers\FrontendController::class, 'serveLaporanFile']);
    
    // Informasi Pemkab
    Route::get('/informasi-pemkab', [App\Http\Controllers\Api\InformasiPemkabController::class, 'index'])->middleware('optional.sanctum');
    Route::get('/informasi-pemkab/{slug}', [App\Http\Controllers\Api\InformasiPemkabController::class, 'show'])->middleware('optional.sanctum');

    // SAQ E-Monev (navigasi tersembunyi /saq)
    Route::get('/saq/lock-status', [App\Http\Controllers\Api\SaqController::class, 'lockStatus'])->middleware('optional.sanctum');
    Route::get('/saq/opds', [App\Http\Controllers\Api\SaqController::class, 'opds'])->middleware('optional.sanctum');
    Route::get('/saq/structure', [App\Http\Controllers\Api\SaqController::class, 'structure'])->middleware('optional.sanctum');
    Route::get('/saq/answers', [App\Http\Controllers\Api\SaqController::class, 'answers'])->middleware('optional.sanctum');
    Route::get('/saq/all-answers', [App\Http\Controllers\Api\SaqController::class, 'allAnswers'])->middleware('optional.sanctum');
    Route::get('/saq/download-evidence', [App\Http\Controllers\Api\SaqController::class, 'downloadEvidence'])->middleware('optional.sanctum');
    Route::get('/saq/sync', [App\Http\Controllers\Api\SaqController::class, 'sync'])->middleware('optional.sanctum');

    // Daftar Pekerjaan (Auto-complete / Dropdown)
    Route::get('/pekerjaan', [PermohonanInformasiController::class, 'getPekerjaanList']);
    
    // Permohonan Informasi (Formulir via Android / Web)
    Route::post('/permohonan', [PermohonanInformasiController::class, 'store'])->middleware('check.spam');
    Route::get('/permohonan/status/{code}', [PermohonanInformasiController::class, 'checkStatus']);
    Route::get('/permohonan/status/{code}/pdf', [PermohonanInformasiController::class, 'downloadPdf']);

    // Keberatan atas Permohonan Informasi (UU No. 14/2008 & Perki No. 1/2021)
    Route::post('/keberatan', [\App\Http\Controllers\Api\KeberatanInformasiController::class, 'store'])->middleware('check.spam');
    Route::get('/keberatan/status/{code}', [\App\Http\Controllers\Api\KeberatanInformasiController::class, 'checkStatus']);
    Route::get('/laporan-keberatan', [\App\Http\Controllers\Api\KeberatanInformasiController::class, 'indexPublic']);

    // Berita, Galeri, Pejabat
    Route::get('/berita', [\App\Http\Controllers\Admin\BeritaController::class, 'index']);
    Route::get('/berita/{slug}', [\App\Http\Controllers\Admin\BeritaController::class, 'show']);
    Route::get('/galeri', [GaleriController::class, 'index']);
    Route::get('/galeri/{id}', [GaleriController::class, 'show']);
    Route::get('/galeri/{id}/download', [GaleriController::class, 'download']);
    Route::get('/pejabat', [OfficialController::class, 'index']);
    
    // Twibbon
    Route::get('/twibbon', [\App\Http\Controllers\Api\TwibbonController::class, 'index']);
    Route::get('/twibbon-proxy', [\App\Http\Controllers\Api\TwibbonController::class, 'proxy']);
    Route::post('/twibbon/save-session', [\App\Http\Controllers\Api\TwibbonController::class, 'saveSession']);
    Route::get('/twibbon/{slug}', [\App\Http\Controllers\Api\TwibbonController::class, 'show']);

    // Visual & Identitas
    Route::get('/sliders', [SliderController::class, 'index']);
    Route::get('/menu', [MenuController::class, 'index']);
    Route::get('/units', [App\Http\Controllers\Api\DinasController::class, 'list']);

    // Statistik & Sistem
    Route::get('/statistik', [StatistikController::class, 'index']);
    Route::get('/health', [HealthController::class, 'index']);
    Route::get('/profil', [App\Http\Controllers\Api\ProfilPpidController::class, 'index']);
    Route::get('/sitemap', [App\Http\Controllers\Api\SitemapController::class, 'index']);

    // Auth & Kontak
    Route::post('/login', [App\Http\Controllers\Api\LoginController::class, 'login']);
    Route::post('/register', [App\Http\Controllers\Api\RegisterController::class, 'register']);
    
    // Google OAuth API routes (Khusus SPA)
    Route::get('/auth/google/redirect', [\App\Http\Controllers\Api\GoogleLoginController::class, 'redirectToGoogle']);
    Route::post('/auth/google/callback-spa', [\App\Http\Controllers\Api\GoogleLoginController::class, 'handleGoogleCallback']);
    
    // OTP Verifications & Resend
    Route::post('/auth/google/resend-otp', [\App\Http\Controllers\Api\GoogleLoginController::class, 'resendOtp']);
    Route::post('/auth/google/register/verify-otp', [\App\Http\Controllers\Api\GoogleLoginController::class, 'verifyRegisterOtp']);
    
    // Unlink / Link OTP (Requires Auth)
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/auth/google/link/verify-otp', [\App\Http\Controllers\Api\GoogleLoginController::class, 'verifyLinkOtp']);
        Route::post('/auth/google/unlink/request-otp', [\App\Http\Controllers\Api\GoogleLoginController::class, 'requestUnlinkOtp']);
        Route::post('/auth/google/unlink/verify', [\App\Http\Controllers\Api\GoogleLoginController::class, 'verifyUnlinkOtp']);
    });

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
        Route::post('/informasi-crud/check-similarity', [\App\Http\Controllers\Admin\InformasiController::class, 'checkSimilarity']);
        Route::post('/informasi-crud', [\App\Http\Controllers\Admin\InformasiController::class, 'store']);
        Route::get('/informasi-crud/{informasi}/edit', [\App\Http\Controllers\Admin\InformasiController::class, 'editApi']);
        Route::post('/informasi-crud/{informasi}', [\App\Http\Controllers\Admin\InformasiController::class, 'update']);
        Route::delete('/informasi-crud/{informasi}', [\App\Http\Controllers\Admin\InformasiController::class, 'destroy']);
        Route::post('/ai-settings/generate', [\App\Http\Controllers\Admin\AiSettingController::class, 'generateInformasi']);
        
        // Informasi Pemkab CRUD
        Route::post('/informasi-pemkab-crud', [\App\Http\Controllers\Admin\InformasiPemkabController::class, 'store']);
        Route::get('/informasi-pemkab-crud/{slug}/edit', [\App\Http\Controllers\Admin\InformasiPemkabController::class, 'editApi']);
        Route::post('/informasi-pemkab-crud/{informasi_pemkab}', [\App\Http\Controllers\Admin\InformasiPemkabController::class, 'update']);
        Route::delete('/informasi-pemkab-crud/{informasi_pemkab}', [\App\Http\Controllers\Admin\InformasiPemkabController::class, 'destroy']);
        
        // SAQ E-Monev (admin login)
        Route::post('/saq/answers', [App\Http\Controllers\Api\SaqController::class, 'store']);
        Route::delete('/saq/answers/{id}', [App\Http\Controllers\Api\SaqController::class, 'destroy']);
        Route::get('/saq/evidence-document-detail', [App\Http\Controllers\Api\SaqController::class, 'getEvidenceDocumentDetail']);
        Route::post('/saq/repair-evidence-document', [App\Http\Controllers\Api\SaqController::class, 'repairEvidenceDocument']);

        // SAQ Admin Management (superadmin only)
        Route::get('/saq-admin/indicators', [\App\Http\Controllers\Admin\SaqAdminController::class, 'index']);
        Route::post('/saq-admin/indicators', [\App\Http\Controllers\Admin\SaqAdminController::class, 'store']);
        Route::get('/saq-admin/indicators/{id}', [\App\Http\Controllers\Admin\SaqAdminController::class, 'show']);
        Route::put('/saq-admin/indicators/{id}', [\App\Http\Controllers\Admin\SaqAdminController::class, 'update']);
        Route::delete('/saq-admin/indicators/{id}', [\App\Http\Controllers\Admin\SaqAdminController::class, 'destroy']);
        Route::put('/saq-admin/indicators/{id}/mapping', [\App\Http\Controllers\Admin\SaqAdminController::class, 'updateMapping']);
        Route::get('/saq-admin/indicators/{id}/similar', [\App\Http\Controllers\Admin\SaqAdminController::class, 'similar']);
        Route::post('/saq-admin/indicators/{id}/move', [\App\Http\Controllers\Admin\SaqAdminController::class, 'move']);
        Route::delete('/saq-admin/indicators/{id}/opd/{opd_id}', [\App\Http\Controllers\Admin\SaqAdminController::class, 'detachOpd']);
        Route::post('/saq-admin/indicators/{id}/opd/{opd_id}', [\App\Http\Controllers\Admin\SaqAdminController::class, 'attachOpd']);
        Route::post('/saq-admin/opd/{opd_id}/indicators', [\App\Http\Controllers\Admin\SaqAdminController::class, 'attachBatchOpd']);
        Route::get('/saq-admin/opds', [\App\Http\Controllers\Admin\SaqAdminController::class, 'opds']);
        Route::get('/saq-admin/tabs', [\App\Http\Controllers\Admin\SaqAdminController::class, 'tabs']);
        Route::get('/saq-admin/sections', [\App\Http\Controllers\Admin\SaqAdminController::class, 'sections']);
        Route::get('/saq-admin/lock-status', [\App\Http\Controllers\Admin\SaqAdminController::class, 'getLockStatus']);
        Route::post('/saq-admin/toggle-lock', [\App\Http\Controllers\Admin\SaqAdminController::class, 'toggleLock']);
        Route::post('/saq-admin/reset-answers', [\App\Http\Controllers\Admin\SaqAdminController::class, 'resetAnswers']);
        
        // Twibbon CRUD
        Route::post('/twibbon', [\App\Http\Controllers\Admin\TwibbonController::class, 'store']);
        Route::post('/twibbon/{slug}', [\App\Http\Controllers\Admin\TwibbonController::class, 'update']);
        Route::delete('/twibbon/{id}', [\App\Http\Controllers\Admin\TwibbonController::class, 'destroy']);
        
        // Galeri Admin CRUD
        Route::get('/admin/galeri', [GaleriController::class, 'adminIndex']);
        Route::post('/admin/galeri', [GaleriController::class, 'store']);
        Route::get('/admin/galeri/{id}', [GaleriController::class, 'show']);
        Route::post('/admin/galeri/{id}', [GaleriController::class, 'update']);
        Route::delete('/admin/galeri/{id}', [GaleriController::class, 'destroy']);
        Route::post('/admin/galeri/{id}/toggle-pin', [GaleriController::class, 'togglePin']);
        
        Route::get('/profil/pimpinan/{slug}/edit', [ProfilController::class, 'editOfficial']);
        Route::post('/profil/pimpinan/{slug}', [ProfilController::class, 'updateOfficial']);
        
        Route::get('/profil/kelola-opd/{organization}/edit', [ProfilController::class, 'editOpdManage']);
        Route::post('/profil/kelola-opd/{organization}', [ProfilController::class, 'updateOpdManage']);

        Route::get('/user', function (Request $request) {
            $user = $request->user();
            if ($user && empty($user->unit_id) && !empty($user->nip)) {
                $apiData = \App\Models\User::getDataFromApi($user->nip);
                if (!empty($apiData['unit_id'])) {
                    $user->unit_id = $apiData['unit_id'];
                    $user->save();
                }
            }
            if ($user && $user->unit_id) {
                $org = \App\Models\Organization::where('remote_id', (string)$user->unit_id)
                    ->orWhere('unit_id', (string)$user->unit_id)
                    ->orWhere('id', $user->unit_id)
                    ->first();
                if ($org) {
                    $user->organization_id = $org->id;
                    $user->organization_slug = $org->slug;
                    $user->organization_name = $org->name;
                }
            }
            return $user;
        });

        // Profile Management
        Route::get('/profile', [App\Http\Controllers\Api\ProfileController::class, 'show']);
        Route::post('/profile', [App\Http\Controllers\Api\ProfileController::class, 'update']);
        Route::post('/profile/merge', [App\Http\Controllers\Api\ProfileController::class, 'mergeAccount']);

        // My Information Requests (Mobile Tracking)
        Route::get('/my-requests', [PermohonanInformasiController::class, 'myRequests']);
        Route::get('/my-requests/{id}', [PermohonanInformasiController::class, 'show']);
        Route::post('/my-requests/{id}', [PermohonanInformasiController::class, 'update']); // Use POST as proxy for update due to common mobile fetch limitations

        // My Objections (Keberatan Informasi)
        Route::get('/keberatan/saya', [\App\Http\Controllers\Api\KeberatanInformasiController::class, 'myRequests']);
        Route::get('/keberatan/{id}', [\App\Http\Controllers\Api\KeberatanInformasiController::class, 'show']);

        // === Admin Permohonan & Keberatan & Laporan PDF ===
        Route::prefix('admin')->group(function () {
            Route::get('/dashboard', [\App\Http\Controllers\Api\Admin\AdminDashboardController::class, 'index']);
            Route::get('/permohonan', [\App\Http\Controllers\Api\Admin\PermohonanKeberatanAdminController::class, 'getPermohonan']);
            Route::get('/permohonan/{id}', [\App\Http\Controllers\Api\Admin\PermohonanKeberatanAdminController::class, 'showPermohonan']);
            Route::post('/permohonan/{id}/respond', [\App\Http\Controllers\Api\Admin\PermohonanKeberatanAdminController::class, 'respondPermohonan']);
            Route::post('/permohonan/{id}/status', [\App\Http\Controllers\Api\Admin\PermohonanKeberatanAdminController::class, 'updatePermohonanStatus']);

            Route::get('/keberatan', [\App\Http\Controllers\Api\Admin\PermohonanKeberatanAdminController::class, 'getKeberatan']);
            Route::get('/keberatan/{id}', [\App\Http\Controllers\Api\Admin\PermohonanKeberatanAdminController::class, 'showKeberatan']);
            Route::post('/keberatan/{id}/respond', [\App\Http\Controllers\Api\Admin\PermohonanKeberatanAdminController::class, 'respondKeberatan']);

            Route::get('/reports/export-pdf', [\App\Http\Controllers\Api\Admin\PermohonanKeberatanAdminController::class, 'exportLaporanPdf']);

            // === Unified Admin CRUD ===
            Route::get('/standar-layanan', [\App\Http\Controllers\Api\Admin\UnifiedAdminCrudController::class, 'getStandarLayanan']);
            Route::get('/standar-layanan/{id}', [\App\Http\Controllers\Api\Admin\UnifiedAdminCrudController::class, 'showStandarLayanan']);
            Route::post('/standar-layanan', [\App\Http\Controllers\Api\Admin\UnifiedAdminCrudController::class, 'storeStandarLayanan']);
            Route::post('/standar-layanan/{id}', [\App\Http\Controllers\Api\Admin\UnifiedAdminCrudController::class, 'updateStandarLayanan']);
            Route::delete('/standar-layanan/{id}', [\App\Http\Controllers\Api\Admin\UnifiedAdminCrudController::class, 'deleteStandarLayanan']);

            Route::get('/profil-ppid', [\App\Http\Controllers\Api\Admin\UnifiedAdminCrudController::class, 'getProfilPpid']);
            Route::post('/profil-ppid', [\App\Http\Controllers\Api\Admin\UnifiedAdminCrudController::class, 'updateProfilPpid']);

            Route::get('/officials', [\App\Http\Controllers\Api\Admin\UnifiedAdminCrudController::class, 'getOfficials']);
            Route::get('/officials/{id}', [\App\Http\Controllers\Api\Admin\UnifiedAdminCrudController::class, 'showOfficial']);
            Route::post('/officials', [\App\Http\Controllers\Api\Admin\UnifiedAdminCrudController::class, 'storeOfficial']);
            Route::post('/officials/{id}', [\App\Http\Controllers\Api\Admin\UnifiedAdminCrudController::class, 'updateOfficial']);
            Route::delete('/officials/{id}', [\App\Http\Controllers\Api\Admin\UnifiedAdminCrudController::class, 'deleteOfficial']);

            Route::get('/organizations', [\App\Http\Controllers\Api\Admin\UnifiedAdminCrudController::class, 'getOrganizations']);
            Route::get('/organizations/{id}', [\App\Http\Controllers\Api\Admin\UnifiedAdminCrudController::class, 'showOrganization']);
            Route::post('/organizations', [\App\Http\Controllers\Api\Admin\UnifiedAdminCrudController::class, 'storeOrganization']);
            Route::put('/organizations/{id}', [\App\Http\Controllers\Api\Admin\UnifiedAdminCrudController::class, 'updateOrganization']);
            Route::delete('/organizations/{id}', [\App\Http\Controllers\Api\Admin\UnifiedAdminCrudController::class, 'deleteOrganization']);

            Route::get('/sliders', [\App\Http\Controllers\Api\Admin\UnifiedAdminCrudController::class, 'getSliders']);
            Route::get('/sliders/{id}', [\App\Http\Controllers\Api\Admin\UnifiedAdminCrudController::class, 'showSlider']);
            Route::post('/sliders', [\App\Http\Controllers\Api\Admin\UnifiedAdminCrudController::class, 'storeSlider']);
            Route::post('/sliders/{id}', [\App\Http\Controllers\Api\Admin\UnifiedAdminCrudController::class, 'updateSlider']);
            Route::delete('/sliders/{id}', [\App\Http\Controllers\Api\Admin\UnifiedAdminCrudController::class, 'deleteSlider']);

            Route::get('/surveys', [\App\Http\Controllers\Api\Admin\UnifiedAdminCrudController::class, 'getSurveys']);
            Route::get('/surveys/{id}', [\App\Http\Controllers\Api\Admin\UnifiedAdminCrudController::class, 'showSurvey']);
            Route::post('/surveys', [\App\Http\Controllers\Api\Admin\UnifiedAdminCrudController::class, 'storeSurvey']);
            Route::put('/surveys/{id}', [\App\Http\Controllers\Api\Admin\UnifiedAdminCrudController::class, 'updateSurvey']);
            Route::delete('/surveys/{id}', [\App\Http\Controllers\Api\Admin\UnifiedAdminCrudController::class, 'deleteSurvey']);
            Route::get('/pbj-questions', [\App\Http\Controllers\Api\Admin\UnifiedAdminCrudController::class, 'getPbjQuestions']);
            Route::get('/pbj-questions/{id}', [\App\Http\Controllers\Api\Admin\UnifiedAdminCrudController::class, 'showPbjQuestion']);
            Route::post('/pbj-questions', [\App\Http\Controllers\Api\Admin\UnifiedAdminCrudController::class, 'storePbjQuestion']);
            Route::put('/pbj-questions/{id}', [\App\Http\Controllers\Api\Admin\UnifiedAdminCrudController::class, 'updatePbjQuestion']);
            Route::delete('/pbj-questions/{id}', [\App\Http\Controllers\Api\Admin\UnifiedAdminCrudController::class, 'deletePbjQuestion']);

            Route::get('/users', [\App\Http\Controllers\Api\Admin\UnifiedAdminCrudController::class, 'getUsers']);
            Route::get('/users/{id}', [\App\Http\Controllers\Api\Admin\UnifiedAdminCrudController::class, 'showUser']);
            Route::post('/users', [\App\Http\Controllers\Api\Admin\UnifiedAdminCrudController::class, 'storeUser']);
            Route::put('/users/{id}', [\App\Http\Controllers\Api\Admin\UnifiedAdminCrudController::class, 'updateUser']);
            Route::delete('/users/{id}', [\App\Http\Controllers\Api\Admin\UnifiedAdminCrudController::class, 'deleteUser']);

            Route::get('/security-blocks', [\App\Http\Controllers\Api\Admin\UnifiedAdminCrudController::class, 'getSecurityBlocks']);
            Route::get('/security-blocks/{id}', [\App\Http\Controllers\Api\Admin\UnifiedAdminCrudController::class, 'showSecurityBlock']);
            Route::post('/security-blocks', [\App\Http\Controllers\Api\Admin\UnifiedAdminCrudController::class, 'storeSecurityBlock']);
            Route::put('/security-blocks/{id}', [\App\Http\Controllers\Api\Admin\UnifiedAdminCrudController::class, 'updateSecurityBlock']);
            Route::delete('/security-blocks/{id}', [\App\Http\Controllers\Api\Admin\UnifiedAdminCrudController::class, 'deleteSecurityBlock']);

            // Informasi Admin Index
            Route::get('/informasi', function (\Illuminate\Http\Request $request) {
                $user = $request->user();
                $isSuperAdmin = ($user && $user->role === 'superadmin');
                $userUnitId = $user ? ($user->unit_id ?? null) : null;

                $query = \App\Models\Informasi::query();
                if (!$isSuperAdmin && $userUnitId) {
                    $query->where('unit_id', $userUnitId);
                }

                if ($request->filled('category')) {
                    $query->where('category', $request->category);
                }
                if ($request->filled('q')) {
                    $q = $request->q;
                    $query->where(function($sub) use ($q) {
                        $sub->where('title', 'LIKE', "%{$q}%")
                            ->orWhere('deskripsi', 'LIKE', "%{$q}%");
                    });
                }

                $informasi = $query->orderBy('created_at', 'desc')->paginate($request->get('per_page', 15));
                return response()->json([
                    'success' => true,
                    'data' => $informasi
                ]);
            });

            // Laporan Tahunan & Layanan Admin Endpoints
            Route::get('/laporan', function (\Illuminate\Http\Request $request) {
                $query = \App\Models\Laporan::query();
                if ($request->filled('type')) {
                    $query->where('type', $request->type);
                }
                if ($request->filled('tahun')) {
                    $query->where('tahun', $request->tahun);
                }
                if ($request->filled('q')) {
                    $query->where('title', 'LIKE', "%{$request->q}%");
                }
                $data = $query->orderBy('tahun', 'desc')->latest()->paginate($request->get('per_page', 10));
                return response()->json(['success' => true, 'data' => $data]);
            });

            Route::get('/laporan/{id}', function ($id) {
                $item = \App\Models\Laporan::findOrFail($id);
                return response()->json(['success' => true, 'data' => $item]);
            });

            Route::post('/laporan', function (\Illuminate\Http\Request $request) {
                $validated = $request->validate([
                    'title' => 'required|string|max:255',
                    'tahun' => 'required|integer',
                    'type' => 'nullable|string',
                    'content' => 'nullable|string',
                    'cover' => 'nullable|image|max:2048',
                    'file' => 'nullable|file|mimes:pdf|max:20480',
                    'published' => 'nullable',
                ]);

                $coverPath = null;
                if ($request->hasFile('cover')) {
                    $coverPath = $request->file('cover')->store('laporan/covers', 'public');
                }
                $filePath = null;
                if ($request->hasFile('file')) {
                    $filePath = $request->file('file')->store('laporan/files', 'public');
                }

                $laporan = \App\Models\Laporan::create([
                    'title' => $validated['title'],
                    'tahun' => $validated['tahun'],
                    'type' => $request->input('type', 'tahunan'),
                    'content' => $request->input('content'),
                    'cover' => $coverPath,
                    'file' => $filePath,
                    'published' => filter_var($request->input('published', true), FILTER_VALIDATE_BOOLEAN),
                ]);

                return response()->json(['success' => true, 'data' => $laporan]);
            });

            Route::post('/laporan/{id}', function (\Illuminate\Http\Request $request, $id) {
                $laporan = \App\Models\Laporan::findOrFail($id);
                $validated = $request->validate([
                    'title' => 'required|string|max:255',
                    'tahun' => 'required|integer',
                    'type' => 'nullable|string',
                    'content' => 'nullable|string',
                    'cover' => 'nullable|image|max:2048',
                    'file' => 'nullable|file|mimes:pdf|max:20480',
                    'published' => 'nullable',
                ]);

                $updateData = [
                    'title' => $validated['title'],
                    'tahun' => $validated['tahun'],
                    'type' => $request->input('type', $laporan->type ?? 'tahunan'),
                    'content' => $request->input('content', $laporan->content),
                    'published' => filter_var($request->input('published', $laporan->published), FILTER_VALIDATE_BOOLEAN),
                ];

                if ($request->hasFile('cover')) {
                    if ($laporan->cover) {
                        \Illuminate\Support\Facades\Storage::disk('public')->delete($laporan->cover);
                    }
                    $updateData['cover'] = $request->file('cover')->store('laporan/covers', 'public');
                }

                if ($request->hasFile('file')) {
                    if ($laporan->file) {
                        \Illuminate\Support\Facades\Storage::disk('public')->delete($laporan->file);
                    }
                    $updateData['file'] = $request->file('file')->store('laporan/files', 'public');
                }

                $laporan->update($updateData);
                return response()->json(['success' => true, 'data' => $laporan]);
            });

            Route::delete('/laporan/{id}', function ($id) {
                $laporan = \App\Models\Laporan::findOrFail($id);
                if ($laporan->cover) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($laporan->cover);
                }
                if ($laporan->file) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($laporan->file);
                }
                $laporan->delete();
                return response()->json(['success' => true, 'message' => 'Laporan berhasil dihapus.']);
            });

            // LHKPN Admin Endpoints
            Route::get('/lhkpn-admin', function (\Illuminate\Http\Request $request) {
                $year = $request->get('year', \App\Models\Lhkpn::max('report_year') ?? date('Y'));
                $query = \App\Models\Lhkpn::with(['official.organization', 'official.position', 'organization']);
                if ($request->filled('year')) {
                    $query->where('report_year', $request->year);
                }
                if ($request->filled('q')) {
                    $q = $request->q;
                    $query->whereHas('official', function($sub) use ($q) {
                        $sub->where('full_name', 'LIKE', "%{$q}%");
                    });
                }
                $data = $query->latest()->paginate($request->get('per_page', 15));
                return response()->json(['success' => true, 'data' => $data, 'selected_year' => $year]);
            });

            Route::post('/lhkpn-admin', function (\Illuminate\Http\Request $request) {
                $validated = $request->validate([
                    'official_id' => 'nullable|integer',
                    'organization_id' => 'nullable|integer',
                    'report_year' => 'required|integer',
                    'status' => 'required|string',
                    'submission_date' => 'nullable|date',
                    'announcement_date' => 'nullable|date',
                    'receipt_number' => 'nullable|string',
                    'elhkpn_url' => 'nullable|url',
                    'receipt_file' => 'nullable|file|mimes:pdf,jpg,png|max:5120',
                    'is_special_official' => 'nullable|boolean',
                    'notes' => 'nullable|string'
                ]);

                $filePath = null;
                if ($request->hasFile('receipt_file')) {
                    $filePath = $request->file('receipt_file')->store('lhkpn', 'public');
                }

                $lhkpn = \App\Models\Lhkpn::create([
                    'official_id' => $validated['official_id'] ?? null,
                    'organization_id' => $validated['organization_id'] ?? null,
                    'report_year' => $validated['report_year'],
                    'status' => $validated['status'],
                    'submission_date' => $validated['submission_date'] ?? null,
                    'announcement_date' => $validated['announcement_date'] ?? null,
                    'receipt_number' => $validated['receipt_number'] ?? null,
                    'elhkpn_url' => $validated['elhkpn_url'] ?? null,
                    'receipt_file_path' => $filePath,
                    'is_special_official' => $request->boolean('is_special_official'),
                    'notes' => $validated['notes'] ?? null
                ]);

                return response()->json(['success' => true, 'data' => $lhkpn]);
            });

            Route::delete('/lhkpn-admin/{id}', function ($id) {
                $item = \App\Models\Lhkpn::findOrFail($id);
                if ($item->receipt_file_path) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($item->receipt_file_path);
                }
                $item->delete();
                return response()->json(['success' => true, 'message' => 'Data LHKPN berhasil dihapus.']);
            });
        });

        Route::post('/logout', [App\Http\Controllers\Api\LoginController::class, 'logout']);
        Route::post('/force-change-password', [App\Http\Controllers\Api\LoginController::class, 'forceChangePassword']);
    });

});

// Fallback rute lama (jika masih ada yang pakai, agar tidak langsung error)
Route::get('/health', [HealthController::class, 'index']);
Route::middleware('throttle:30,1')->group(function () {
    Route::post('/telegram/webhook', [\App\Http\Controllers\Api\TelegramWebhookController::class, 'handle']);
    Route::match(['get', 'post'], '/whatsapp/webhook', [\App\Http\Controllers\Api\WhatsAppWebhookController::class, 'handle']);
});
