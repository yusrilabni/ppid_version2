<?php

use App\Http\Controllers\LaporanPermohonanController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\HybridLoginController;
use App\Http\Controllers\Api\DinasController;
use App\Http\Controllers\PublicSurveyController;
use App\Http\Controllers\Frontend\PbjController;
use App\Http\Controllers\Frontend\DIPController;
use App\Http\Controllers\Frontend\LhkpnController;
use App\Http\Controllers\Frontend\ExtraToolsController;

Route::get('/sitemap.xml', function () {
    $xml = '<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>' . url('/') . '</loc>
        <lastmod>' . now()->toAtomString() . '</lastmod>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>
</urlset>';

    return response($xml)->header('Content-Type', 'application/xml');
});

// Proxy route for DIP Unit
Route::get('/dipunit', [DinasController::class, 'index'])->name('dipunit.index');
Route::get('/dipunit/dip/{organization:slug}', [DinasController::class, 'opdDip'])->name('opd.dip.show');
Route::get('/dipunit/dip/{organization:slug}/export', [DinasController::class, 'export'])->name('opd.dip.export');

// RSS Feed & Widget Routes
Route::get('/rss-feed', [ExtraToolsController::class, 'rssIndex'])->name('extra.rss');
Route::get('/rss/generate', [ExtraToolsController::class, 'rssGenerate'])->name('extra.rss.generate');
Route::get('/widget', [ExtraToolsController::class, 'widgetIndex'])->name('extra.widget');
Route::get('/widgets/embed', [ExtraToolsController::class, 'widgetLatest'])->name('extra.widgets.embed');

// Proxy Share Route untuk WhatsApp Bot (mengarahkan ke Vue SPA)
// Generator OG Image Dinamis (Resolusi 1200x630 dengan background putih agar tidak gepeng di WA)
Route::get('/share/og-image/logo', function () {
    $logoPath = public_path('storage/logo/Lambang_Kabupaten_Sinjai.png');
    if (!file_exists($logoPath)) {
        abort(404);
    }
    
    // Baca gambar asli
    $logo = imagecreatefromstring(file_get_contents($logoPath));
    $logoW = imagesx($logo);
    $logoH = imagesy($logo);
    
    // Target ukuran Open Graph (WhatsApp/FB Standard)
    $canvasW = 1200;
    $canvasH = 630;
    
    // Buat kanvas putih
    $canvas = imagecreatetruecolor($canvasW, $canvasH);
    $white = imagecolorallocate($canvas, 255, 255, 255);
    imagefill($canvas, 0, 0, $white);
    
    // Hitung skala agar logo muat di tengah dengan padding
    $padding = 50; // Jarak atas bawah
    $targetH = $canvasH - ($padding * 2);
    $scale = $targetH / $logoH;
    $targetW = $logoW * $scale;
    
    // Posisi tengah
    $dstX = ($canvasW - $targetW) / 2;
    $dstY = $padding;
    
    // Salin dan ubah ukuran logo ke kanvas
    imagecopyresampled($canvas, $logo, $dstX, $dstY, 0, 0, $targetW, $targetH, $logoW, $logoH);
    
    ob_start();
    imagepng($canvas);
    $imgData = ob_get_clean();
    imagedestroy($canvas);
    imagedestroy($logo);
    
    return response($imgData)->header('Content-Type', 'image/png')->header('Cache-Control', 'public, max-age=86400');
})->name('share.og-image');

Route::get('/share/informasi-pemkab/{slug?}', function (\Illuminate\Http\Request $request, $slug = null) {
    if ($slug) {
        // Detail Dokumen
        $dokumen = \App\Models\InformasiPemkab::where('slug', $slug)->orWhere('id', $slug)->firstOrFail();
        $title = $dokumen->judul . ' - PPID Kabupaten Sinjai';
        $desc = $dokumen->deskripsi ?? 'Transparansi Informasi Publik Pemerintah Kabupaten Sinjai';
        $imageUrl = url('/share/og-image/logo');
        $redirectUrl = "https://ppid.sinjaikab.go.id/transparansi/informasi-pemkab/" . ($dokumen->slug ?? $dokumen->id);
    } else {
        // Index dengan Filter
        $title = 'PPID - Informasi Pemkab';
        if ($request->kategori) $title .= ' - ' . $request->kategori;
        if ($request->jenis_dokumen) $title .= ' - ' . $request->jenis_dokumen;
        
        $desc = 'Daftar Dokumen Informasi Pemkab Kabupaten Sinjai';
        $imageUrl = url('/share/og-image/logo');
        
        // Build redirect URL with query params
        $queryString = $request->getQueryString();
        $redirectUrl = "https://ppid.sinjaikab.go.id/transparansi/informasi-pemkab" . ($queryString ? '?' . $queryString : '');
    }

    return <<<HTML
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>{$title}</title>
    <meta property="og:title" content="{$title}">
    <meta property="og:description" content="{$desc}">
    <meta property="og:image" content="{$imageUrl}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{$redirectUrl}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:image" content="{$imageUrl}">
    <script>window.location.replace("{$redirectUrl}");</script>
</head>
<body style="font-family: sans-serif; text-align: center; padding-top: 50px;">
    <p>Sedang mengarahkan ke halaman... <br><br><a href="{$redirectUrl}" style="color: #2563eb; text-decoration: none; font-weight: bold;">Klik di sini jika tidak diarahkan secara otomatis</a></p>
</body>
</html>
HTML;
})->name('share.proxy.informasi-pemkab');

// Public routes
Route::get('/', [FrontendController::class, 'home'])->name('home');
Route::get('/search', [FrontendController::class, 'search'])->name('frontend.informasi.search');
Route::post('/contact', [FrontendController::class, 'submitContactForm'])->name('contact.submit');
Route::get('/galeri/all', [FrontendController::class, 'allGaleri'])->name('frontend.galeri.all');
Route::get('/galeri/detail/{hash}', [FrontendController::class, 'showGaleri'])->name('frontend.galeri.show');

// DIP (Daftar Informasi Publik) Routes
Route::get('/dip', [DIPController::class, 'index'])->name('dip.index');
Route::get('/dip/{year}', [DIPController::class, 'show'])->name('dip.show');
Route::get('/dip/{year}/export', [DIPController::class, 'export'])->name('dip.export');

// Permohonan Informasi Routes
Route::get('/laporan/permohonan', [LaporanPermohonanController::class, 'index'])->name('laporan.permohonan.index');
Route::get('/laporan/permohonan/create', [LaporanPermohonanController::class, 'create'])->name('laporan.permohonan.create');
Route::get('/laporan/permohonan/saya', [LaporanPermohonanController::class, 'myRequests'])->name('laporan.permohonan.saya')->middleware('auth');
Route::post('/laporan/permohonan/store', [LaporanPermohonanController::class, 'store'])->name('laporan.permohonan.store')->middleware(['auth', 'throttle:10,1']);
Route::get('/laporan/permohonan/{permohonanInformasi}', [LaporanPermohonanController::class, 'show'])->name('laporan.permohonan.show');
Route::get('/laporan/permohonan/{permohonanInformasi}/edit', [LaporanPermohonanController::class, 'edit'])->name('laporan.permohonan.edit')->middleware('auth');
Route::put('/laporan/permohonan/{permohonanInformasi}', [LaporanPermohonanController::class, 'update'])->name('laporan.permohonan.update')->middleware('auth');
Route::delete('/laporan/permohonan/{permohonanInformasi}', [LaporanPermohonanController::class, 'destroy'])->name('laporan.permohonan.destroy')->middleware('auth');
Route::get('/laporan/permohonan/{permohonanInformasi}/pdf', [LaporanPermohonanController::class, 'downloadPDF'])->name('laporan.permohonan.pdf')->middleware('auth');
Route::post('/laporan/permohonan/{permohonanInformasi}/respond', [LaporanPermohonanController::class, 'addResponse'])->name('laporan.permohonan.respond')->middleware('auth');
Route::post('/laporan/permohonan/{permohonanInformasi}/rate', [LaporanPermohonanController::class, 'rate'])->name('laporan.permohonan.rate')->middleware('auth');

// Public Survey Routes
Route::get('/surveys/thank-you', [PublicSurveyController::class, 'thankyou'])->name('public.surveys.thankyou');
Route::get('/surveys/{survey}', [PublicSurveyController::class, 'show'])->name('public.surveys.show');
Route::post('/surveys/{survey}', [PublicSurveyController::class, 'store'])->name('public.surveys.store');

// Hybrid Authentication Routes
Route::get('/login', [HybridLoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [HybridLoginController::class, 'login']);
Route::get('/register', [HybridLoginController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [HybridLoginController::class, 'register']);
Route::post('/logout', [HybridLoginController::class, 'logout'])->name('logout');
Route::get('/logout', function() {
    return redirect()->route('login');
});

// OAuth & Security
Route::get('/auth/google', [HybridLoginController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [HybridLoginController::class, 'handleGoogleCallback']);
Route::get('/login/protection/verify', [App\Http\Controllers\Auth\LoginProtectionController::class, 'showVerificationForm'])->name('login.protection.verify');
Route::post('/login/protection/verify', [App\Http\Controllers\Auth\LoginProtectionController::class, 'verify'])->name('login.protection.verify.post');

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () { return view('dashboard'); })->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('informasi-crud', [App\Http\Controllers\Admin\InformasiController::class, 'index'])->name('informasi-crud.index');
    Route::get('informasi-crud/create/{category?}', [App\Http\Controllers\Admin\InformasiController::class, 'create'])->name('informasi-crud.create');
    Route::post('informasi-crud', [App\Http\Controllers\Admin\InformasiController::class, 'store'])->name('informasi-crud.store');
    Route::get('informasi-crud/{informasi}/edit', [App\Http\Controllers\Admin\InformasiController::class, 'edit'])->name('informasi-crud.edit');
    Route::put('informasi-crud/{informasi}', [App\Http\Controllers\Admin\InformasiController::class, 'update'])->name('informasi-crud.update');
    Route::delete('informasi-crud/{informasi}', [App\Http\Controllers\Admin\InformasiController::class, 'destroy'])->name('informasi-crud.destroy');
    Route::match(['get', 'post'], 'informasi-crud/check-similarity', [App\Http\Controllers\Admin\InformasiController::class, 'checkSimilarity'])->name('admin.informasi.check_similarity');

    // Manage Pimpinan via Frontend (INI YANG BERHASIL)
    Route::get('/profil/pimpinan/{official}/edit', [FrontendController::class, 'editPimpinanPublic'])->name('pimpinan.edit-public');
    Route::put('/profil/pimpinan/{official}', [FrontendController::class, 'updatePimpinanPublic'])->name('pimpinan.update-public');

    // Manage Tentang OPD via Frontend (Explicit ID binding to avoid slug collision)
    Route::get('/profil/kelola-opd/{organization:id}/edit', [FrontendController::class, 'manageStrukturOrganisasiPublic'])->name('opd.manage-public');
    Route::post('/profil/kelola-opd/{organization:id}/update', [FrontendController::class, 'updateStrukturOrganisasiPublic'])->name('opd.update-public');
});

// Category & Detail Routes
Route::get('/informasi/{category}', [FrontendController::class, 'informasiByCategory'])->name('frontend.informasi.category');
Route::get('/informasi/show/{informasi}', [FrontendController::class, 'show'])->name('frontend.informasi.show');
Route::get('/informasi/detail/{slug}', [FrontendController::class, 'detailBySlug'])->name('frontend.informasi.detail');
Route::get('/informasi/download/{id}', [FrontendController::class, 'download'])->name('frontend.informasi.download');
Route::get('/informasi/visit-url/{id}', [FrontendController::class, 'visitUrl'])->name('frontend.informasi.visit-url');

// Informasi Pemkab Route
Route::get('/transparansi/informasi-pemkab', [\App\Http\Controllers\Front\InformasiPemkabController::class, 'index'])->name('frontend.informasi-pemkab.index');
Route::get('/transparansi/informasi-pemkab/{informasi_pemkab:slug}', [\App\Http\Controllers\Front\InformasiPemkabController::class, 'show'])->name('frontend.informasi-pemkab.show');
Route::get('/transparansi/informasi-pemkab/{informasi_pemkab:slug}/download', [\App\Http\Controllers\Front\InformasiPemkabController::class, 'download'])->name('frontend.informasi-pemkab.download');

// Admin Resources
Route::prefix('admin')->name('admin.')->group(function () {
    // Load all routes from admin.php (Middleware is handled inside that file)
    require __DIR__ . '/admin.php';
});

// Profil & OPD Pages
Route::get('/profil/ppid', [FrontendController::class, 'showProfilPpid'])->name('frontend.profil-ppid.show');
Route::get('/profil/organisasi/{organization:slug}', [FrontendController::class, 'organizationDetail'])->name('organization.detail');
Route::get('/profil/tentang-opd', [FrontendController::class, 'opdList'])->name('opd.list');
Route::get('/profil/tentang-opd/{organization:slug}', [FrontendController::class, 'opdDetail'])->name('opd.detail');
Route::get('/profil/bupati', fn() => app(\App\Http\Controllers\OfficialProfileController::class)->show('bupati-sinjai'))->name('official.bupati');
Route::get('/profil/wakil-bupati', fn() => app(\App\Http\Controllers\OfficialProfileController::class)->show('wakil-bupati-sinjai'))->name('official.wakil-bupati');
Route::get('/profil/sekretaris-daerah', fn() => app(\App\Http\Controllers\OfficialProfileController::class)->show('sekretaris-daerah-sinjai'))->name('official.sekretaris-daerah');
Route::get('/profil/pejabat-daerah', [\App\Http\Controllers\OfficialProfileController::class, 'listKepalaOpd'])->name('official.pejabat-daerah');
Route::get('/profil/unit-lokal', [\App\Http\Controllers\UnitLokalController::class, 'index'])->name('official.unit-lokal');
Route::get('/profil/{slug}', [\App\Http\Controllers\OfficialProfileController::class, 'show'])->name('official.profile.show');

// PBJ & Standar Layanan
Route::get('/pbj', [PbjController::class, 'index'])->name('pbj.index');
Route::get('/pbj/{year}', [PbjController::class, 'show'])->name('pbj.show');
Route::post('/pbj/{year}', [PbjController::class, 'store'])->name('pbj.store');
Route::get('/standar-layanan/{slug}', [App\Http\Controllers\Frontend\StandarLayananController::class, 'showBySlug'])->name('frontend.standar-layanan.showBySlug');
Route::get('/standar-layanan/file/{subStandarLayanan:slug}', [App\Http\Controllers\Frontend\StandarLayananController::class, 'showFileDetail'])->name('frontend.standar-layanan.file-detail');
Route::get('/standar-layanan/download/{subStandarLayanan}', [App\Http\Controllers\Frontend\StandarLayananController::class, 'download'])->name('frontend.standar-layanan.download');
Route::get('/standar-layanan/visit-url/{subStandarLayanan}', [App\Http\Controllers\Frontend\StandarLayananController::class, 'visitUrl'])->name('frontend.standar-layanan.visit-url');

// LHKPN Public Routes
Route::get('/lhkpn/view/{lhkpn}', [LhkpnController::class, 'viewFile'])->name('frontend.lhkpn.view');
Route::get('/lhkpn/{year?}', [LhkpnController::class, 'index'])->name('frontend.lhkpn.index');

// Laporan PPID Routes
Route::get('/laporan/ppid', [FrontendController::class, 'laporanPpid'])->name('laporan.ppid.index');
Route::get('/laporan/ppid/preview/{id}', [FrontendController::class, 'previewLaporan'])->name('laporan.ppid.preview');
Route::get('/laporan/ppid/file/{id}', [FrontendController::class, 'serveLaporanFile'])->name('laporan.ppid.file');

// Storage & Fallback
Route::get('storage/{path}', [App\Http\Controllers\StorageController::class, 'show'])->where('path', '.*')->name('storage.fallback');

// Route Debug WhatsApp (PROTECTED: Auth + Admin Only)
Route::middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])->group(function () {
    Route::get('/wa-debug-view', function() {
        $path = public_path('wa_debug.json');
        if (!file_exists($path)) return response()->json(['error' => 'File debug belum tercipta.'], 404);
        return response()->json(json_decode(file_get_contents($path), true));
    })->name('wa.debug.view');

    Route::get('/test-wa-trigger', function() {
        $url = url('/api/whatsapp/webhook');
        $data = ['from' => 'nomor_test_manual@c.us', 'body' => '#status'];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);

        $response = curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);

        return response()->json([
            'url_target' => $url,
            'http_code' => $info['http_code'],
            'response' => json_decode($response, true) ?: $response,
        ]);
    })->name('wa.test.trigger');

    Route::get('/test-wa-connection', function() {
        $apiUrl = config('ppid.whatsapp.api_url');
        $apiKey = config('ppid.whatsapp.api_key');

        try {
            $response = \Illuminate\Support\Facades\Http::withHeaders([
                'x-api-key' => $apiKey
            ])->timeout(5)->get(str_replace('/api/send', '', $apiUrl));

            return response()->json([
                'status' => 'CONNECTED',
                'http_code' => $response->status(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'FAILED',
                'error' => $e->getMessage(),
                'hint' => 'Hosting mungkin memblokir Port tersebut.'
            ]);
        }
    })->name('wa.test.connection');

    Route::get('/test-wa-send/{phone}', function($phone) {
        // Validasi format nomor telepon
        if (!preg_match('/^[0-9]{8,15}$/', $phone)) {
            return response()->json(['error' => 'Format nomor tidak valid.'], 422);
        }
        $result = \App\Helpers\GeneralHelper::sendWhatsApp($phone, "Halo! Ini adalah pesan tes dari Sistem PPID. Jika Anda menerima ini, berarti integrasi WhatsApp sudah SUKSES! 🚀");
        return response()->json([
            'target_phone' => $phone,
            'send_status' => $result ? 'SUCCESS' : 'FAILED',
            'gateway_response' => json_decode(\App\Helpers\GeneralHelper::$lastWaResponse, true) ?: \App\Helpers\GeneralHelper::$lastWaResponse,
        ]);
    })->name('wa.test.send')->middleware('throttle:3,1');
});

        // Laravel ERD (Bypass environment check - DISABLED IN PRODUCTION)
if (app()->environment('local')) {
    Route::get('/erd', [\Recca0120\LaravelErd\Http\Controllers\LaravelErdController::class, 'index'])->name('erd.index');
}

// CATCH-ALL ROUTE (MUST BE LAST)
Route::get('/{page}/{subpage?}', [FrontendController::class, 'page'])->where(['page' => '[a-z-]+', 'subpage' => '[a-z-]+'])->name('page.show');

require __DIR__ . '/auth.php';
