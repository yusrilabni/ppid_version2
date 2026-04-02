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

// Proxy route for Dinas - moved here for diagnostics
Route::get('/dinas', [DinasController::class, 'index'])->name('dinas.index');
Route::get('/dinas/dip/{organization:slug}', [DinasController::class, 'opdDip'])->name('opd.dip.show');
Route::get('/dinas/dip/{organization:slug}/export', [DinasController::class, 'export'])->name('opd.dip.export');

// RSS Feed & Widget Routes (PRIORITY - MUST BE ABOVE CATCH-ALL)
Route::get('/rss-feed', [ExtraToolsController::class, 'rssIndex'])->name('extra.rss');
Route::get('/rss/generate', [ExtraToolsController::class, 'rssGenerate'])->name('extra.rss.generate');
Route::get('/widget', [ExtraToolsController::class, 'widgetIndex'])->name('extra.widget');
Route::get('/widgets/embed', [ExtraToolsController::class, 'widgetLatest'])->name('extra.widgets.embed');

// Public routes
Route::get('/', [FrontendController::class, 'home'])->name('home');
Route::get('/search', [FrontendController::class, 'search'])->name('frontend.informasi.search');
Route::post('/contact', [FrontendController::class, 'submitContactForm'])->name('contact.submit');
Route::get('/galeri/all', [FrontendController::class, 'allGaleri'])->name('frontend.galeri.all');

// DIP (Daftar Informasi Publik) Routes
Route::get('/dip', [DIPController::class, 'index'])->name('dip.index');
Route::get('/dip/{year}', [DIPController::class, 'show'])->name('dip.show');
Route::get('/dip/{year}/export', [DIPController::class, 'export'])->name('dip.export');

// Permohonan Informasi Routes
Route::get('/laporan/permohonan', [LaporanPermohonanController::class, 'index'])->name('laporan.permohonan.index');
Route::get('/laporan/permohonan/create', [LaporanPermohonanController::class, 'create'])->name('laporan.permohonan.create');
Route::get('/laporan/permohonan/saya', [LaporanPermohonanController::class, 'myRequests'])->name('laporan.permohonan.saya')->middleware('auth');
Route::post('/laporan/permohonan/store', [LaporanPermohonanController::class, 'store'])->name('laporan.permohonan.store')->middleware('auth');
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

// OAuth & Security
Route::get('/auth/google', [HybridLoginController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [HybridLoginController::class, 'handleGoogleCallback']);
Route::get('/login/protection/verify', [App\Http\Controllers\Auth\LoginProtectionController::class, 'showVerificationForm'])->name('login.protection.verify');
Route::post('/login/protection/verify', [App\Http\Controllers\Auth\LoginProtectionController::class, 'verify'])->name('login.protection.verify.post');

// Authenticated Routes
Route::middleware('auth')->group(function () {
    // Priority Route for OPD Management (Frontend)
    Route::get('/manage-opd-profile/{organization}', [FrontendController::class, 'manageStrukturOrganisasiPublic'])->name('opd.manage-public')->whereNumber('organization');
    Route::post('/manage-opd-profile/{organization}', [FrontendController::class, 'updateStrukturOrganisasiPublic'])->name('opd.update-public')->whereNumber('organization');

    Route::get('/dashboard', function () { return view('dashboard'); })->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('informasi-crud', [App\Http\Controllers\Admin\InformasiController::class, 'index'])->name('informasi-crud.index');
    Route::get('informasi-crud/create/{category?}', [App\Http\Controllers\Admin\InformasiController::class, 'create'])->name('informasi-crud.create');
    Route::post('informasi-crud', [App\Http\Controllers\Admin\InformasiController::class, 'store'])->name('informasi-crud.store');
    Route::get('informasi-crud/{informasi}/edit', [App\Http\Controllers\Admin\InformasiController::class, 'edit'])->name('informasi-crud.edit');
    Route::put('informasi-crud/{informasi}', [App\Http\Controllers\Admin\InformasiController::class, 'update'])->name('informasi-crud.update');
    Route::delete('informasi-crud/{informasi}', [App\Http\Controllers\Admin\InformasiController::class, 'destroy'])->name('informasi-crud.destroy');
    Route::post('informasi-crud/check-similarity', [App\Http\Controllers\Admin\InformasiController::class, 'checkSimilarity'])->name('admin.informasi.check_similarity');

    // Manage Pimpinan via Frontend
    Route::get('/profil/pimpinan/{official}/edit', [FrontendController::class, 'editPimpinanPublic'])->name('pimpinan.edit-public');
    Route::put('/profil/pimpinan/{official}', [FrontendController::class, 'updatePimpinanPublic'])->name('pimpinan.update-public');
});

// Category & Detail Routes
Route::get('/informasi/{category}', [FrontendController::class, 'informasiByCategory'])->name('frontend.informasi.category');
Route::get('/informasi/show/{informasi}', [FrontendController::class, 'show'])->name('frontend.informasi.show');
Route::get('/informasi/detail/{slug}', [FrontendController::class, 'detailBySlug'])->name('frontend.informasi.detail');
Route::get('/informasi/download/{id}', [FrontendController::class, 'download'])->name('frontend.informasi.download');
Route::get('/informasi/visit-url/{id}', [FrontendController::class, 'visitUrl'])->name('frontend.informasi.visit-url');

// Admin Resources
Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('my-structure', [\App\Http\Controllers\Admin\StrukturOrganisasiController::class, 'myStructure'])->name('my-structure.manage');
        Route::post('my-structure', [\App\Http\Controllers\Admin\StrukturOrganisasiController::class, 'updateMyStructure'])->name('my-structure.update');
    });

    Route::middleware(['auth', 'verified', \App\Http\Middleware\SuperadminMiddleware::class])->group(function () {
        Route::get('dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
        Route::resource('sliders', App\Http\Controllers\Admin\SliderController::class);
        Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
        Route::resource('galeri', \App\Http\Controllers\Admin\GaleriController::class);
        Route::resource('informasi', \App\Http\Controllers\Admin\InformasiController::class);
        Route::resource('standar-layanan', \App\Http\Controllers\Admin\SubStandarLayananController::class);
        Route::resource('laporan', \App\Http\Controllers\Admin\LaporanController::class);
        Route::resource('statistik', \App\Http\Controllers\Admin\StatistikController::class);
        Route::resource('organizations', \App\Http\Controllers\Admin\OrganizationController::class);
        Route::resource('officials', \App\Http\Controllers\Admin\OfficialController::class);
        Route::resource('surveys', App\Http\Controllers\Admin\SurveyController::class);
        Route::resource('profil-ppid', App\Http\Controllers\Admin\ProfilPpidController::class);
        Route::resource('pbj-questions', \App\Http\Controllers\Admin\PbjQuestionController::class);
        Route::resource('permohonan-informasi', \App\Http\Controllers\Admin\PermohonanInformasiController::class);
        
        Route::get('slider-settings', [App\Http\Controllers\Admin\AdminSettingController::class, 'showSliderSettings'])->name('slider-settings.show');
        Route::post('slider-settings', [App\Http\Controllers\Admin\AdminSettingController::class, 'updateSliderSettings'])->name('slider-settings.update');
        Route::get('lhkpn', [\App\Http\Controllers\Admin\LhkpnController::class, 'index'])->name('lhkpn.index');
        
        // Load all other routes from admin.php
        require __DIR__ . '/admin.php';
    });
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

// CATCH-ALL ROUTE (MUST BE LAST)
Route::get('/{page}/{subpage?}', [FrontendController::class, 'page'])->where(['page' => '[a-z-]+', 'subpage' => '[a-z-]+'])->name('page.show');

require __DIR__ . '/auth.php';
