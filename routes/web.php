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

// Proxy route for Dinas - moved here for diagnostics
Route::get('/dinas', [DinasController::class, 'index'])->name('dinas.index');
Route::get('/dinas/dip/{organization:slug}', [DinasController::class, 'opdDip'])->name('opd.dip.show');
Route::get('/dinas/dip/{organization:slug}/export', [DinasController::class, 'export'])->name('opd.dip.export');


// Public routes
Route::get('/', [App\Http\Controllers\FrontendController::class, 'home'])->name('home');
Route::get('/search', [App\Http\Controllers\FrontendController::class, 'search'])->name('frontend.search');
Route::post('/contact', [App\Http\Controllers\FrontendController::class, 'submitContactForm'])->name('contact.submit');
Route::get('/galeri/all', [App\Http\Controllers\FrontendController::class, 'allGaleri'])->name('frontend.galeri.all');

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

// New Hybrid Authentication Routes
Route::get('/login', [HybridLoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [HybridLoginController::class, 'login']);
Route::get('/register', [HybridLoginController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [HybridLoginController::class, 'register']);
Route::post('/logout', [HybridLoginController::class, 'logout'])->name('logout');

// Google OAuth Routes
Route::get('/auth/google', [HybridLoginController::class, 'redirectToGoogle'])->name('auth.google');      
Route::get('/auth/google/callback', [HybridLoginController::class, 'handleGoogleCallback']);

// Login Protection Route
Route::get('/login/protection/verify', [App\Http\Controllers\Auth\LoginProtectionController::class, 'showVerificationForm'])
    ->name('login.protection.verify');
Route::post('/login/protection/verify', [App\Http\Controllers\Auth\LoginProtectionController::class, 'verify'])
    ->name('login.protection.verify.post');

// Routes requiring standard authentication
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('informasi-crud', [App\Http\Controllers\Admin\InformasiController::class, 'index'])->name('informasi-crud.index');
    Route::get('informasi-crud/create/{category?}', [App\Http\Controllers\Admin\InformasiController::class, 'create'])->name('informasi-crud.create');
    Route::post('informasi-crud', [App\Http\Controllers\Admin\InformasiController::class, 'store'])->name('informasi-crud.store');
    Route::get('informasi-crud/{informasi}/edit', [App\Http\Controllers\Admin\InformasiController::class, 'edit'])->name('informasi-crud.edit');
    Route::put('informasi-crud/{informasi}', [App\Http\Controllers\Admin\InformasiController::class, 'update'])->name('informasi-crud.update');
    Route::delete('informasi-crud/{informasi}', [App\Http\Controllers\Admin\InformasiController::class, 'destroy'])->name('informasi-crud.destroy');
    Route::post('informasi-crud/check-similarity', [\App\Http\Controllers\Admin\InformasiController::class, 'checkSimilarity'])->name('admin.informasi.check_similarity');
});

// Other public routes
Route::get('/informasi/{category}', [FrontendController::class, 'informasiByCategory'])->name('frontend.informasi.category');
Route::get('/informasi/show/{informasi}', [FrontendController::class, 'show'])->name('frontend.informasi.show');
Route::get('/informasi/detail/{slug}', [FrontendController::class, 'detailBySlug'])->name('frontend.informasi.detail');
Route::get('/informasi/download/{id}', [FrontendController::class, 'download'])->name('frontend.informasi.download');
Route::get('/informasi/visit-url/{id}', [FrontendController::class, 'visitUrl'])->name('frontend.informasi.visit-url');

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware(['auth', 'verified'])->group(function () {
        // My Structure
        Route::get('my-structure', [\App\Http\Controllers\Admin\StrukturOrganisasiController::class, 'myStructure'])->name('my-structure.manage');
        Route::post('my-structure', [\App\Http\Controllers\Admin\StrukturOrganisasiController::class, 'updateMyStructure'])->name('my-structure.update');
    });

    Route::middleware(['auth', 'verified', \App\Http\Middleware\SuperadminMiddleware::class])->group(function () {
        // Dashboard
        Route::get('dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
        
        // Resources
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
        Route::resource('surveys.questions', App\Http\Controllers\Admin\SurveyQuestionController::class)->shallow();
        Route::resource('surveys.responses', App\Http\Controllers\Admin\SurveyResponseController::class)->only(['index', 'show']);

        // Additional Settings
        Route::get('slider-settings', [App\Http\Controllers\Admin\AdminSettingController::class, 'showSliderSettings'])->name('slider-settings.show');
        Route::post('slider-settings', [App\Http\Controllers\Admin\AdminSettingController::class, 'updateSliderSettings'])->name('slider-settings.update');

        // PBJ
        Route::resource('pbj-questions', \App\Http\Controllers\Admin\PbjQuestionController::class);
        Route::post('pbj-questions/duplicate', [\App\Http\Controllers\Admin\PbjQuestionController::class, 'duplicate'])->name('pbj-questions.duplicate');
        Route::delete('pbj-questions/delete-year/{year}', [\App\Http\Controllers\Admin\PbjQuestionController::class, 'deleteYear'])->name('pbj-questions.delete-year');
        
        // LHKPN
        Route::get('lhkpn', [\App\Http\Controllers\Admin\LhkpnController::class, 'index'])->name('lhkpn.index');
        Route::delete('lhkpn/{lhkpn}', [\App\Http\Controllers\Admin\LhkpnController::class, 'destroy'])->name('lhkpn.destroy');
        Route::get('lhkpn/create', [\App\Http\Controllers\Admin\LhkpnController::class, 'createForUnit'])->name('lhkpn.create');
        Route::post('lhkpn', [\App\Http\Controllers\Admin\LhkpnController::class, 'storeForUnit'])->name('lhkpn.store');
        Route::get('officials/{official}/lhkpn/create', [\App\Http\Controllers\Admin\LhkpnController::class, 'createForOfficial'])->name('officials.lhkpn.create');
        Route::post('officials/{official}/lhkpn', [\App\Http\Controllers\Admin\LhkpnController::class, 'storeForOfficial'])->name('officials.lhkpn.store');

        // Organization & Positions
        Route::get('organizations/{organization}/structure', [\App\Http\Controllers\Admin\StrukturOrganisasiController::class, 'manage'])->name('organizations.structure.manage');
        Route::post('organizations/{organization}/structure', [\App\Http\Controllers\Admin\StrukturOrganisasiController::class, 'update'])->name('organizations.structure.update');
        Route::get('organizations/{organization}/positions', [\App\Http\Controllers\Admin\OrganizationPositionController::class, 'index'])->name('organizations.positions.index');
        Route::post('reorder-positions', [\App\Http\Controllers\Admin\OrganizationPositionController::class, 'reorder'])->name('reorder-positions');

        // Official Actions
        Route::post('officials/{official}/status', [\App\Http\Controllers\Admin\OfficialController::class, 'updateStatus'])->name('officials.status.update');

        // Permohonan
        Route::resource('permohonan-informasi', \App\Http\Controllers\Admin\PermohonanInformasiController::class);
        Route::post('permohonan-informasi/{permohonan_informasi}/complete', [\App\Http\Controllers\Admin\PermohonanInformasiController::class, 'complete'])->name('permohonan-informasi.complete');
        Route::post('permohonan-informasi/{permohonan_informasi}/reject', [\App\Http\Controllers\Admin\PermohonanInformasiController::class, 'reject'])->name('permohonan-informasi.reject');

        // Reports
        Route::prefix('reports')->name('reports.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\ReportController::class, 'index'])->name('index');
            Route::get('total-export', [\App\Http\Controllers\Admin\ReportController::class, 'exportTotal'])->name('total.export');
            Route::get('informasi-export', [\App\Http\Controllers\Admin\ReportController::class, 'exportInformasi'])->name('informasi.export');
            Route::get('permohonan-export', [\App\Http\Controllers\Admin\ReportController::class, 'exportPermohonan'])->name('permohonan.export');
            Route::get('visitors-export', [\App\Http\Controllers\Admin\ReportController::class, 'exportVisitors'])->name('visitors.export');
            Route::get('survey-export', [\App\Http\Controllers\Admin\ReportController::class, 'exportSurvey'])->name('survey.export');
        });
    });
});

// Organizational Structure Routes moved to admin.php or handled via bootstrap/app.php

// Public organizational structure SVG download route
Route::get('organizations/{organization}/svg-chart', [App\Http\Controllers\Admin\OrganizationPositionController::class, 'generatePublicSvgChart'])->name('public.organizations.svg.chart');

// Organization detail page
Route::get('/profil/organisasi/{organization}', [FrontendController::class, 'organizationDetail'])->name('organization.detail');

// OPD Routes
Route::get('/profil/tentang-opd', [FrontendController::class, 'opdList'])->name('opd.list');
Route::get('/profil/tentang-opd/{organization}', [FrontendController::class, 'opdDetail'])->name('opd.detail');
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profil/tentang-opd/{organization}/manage', [FrontendController::class, 'manageStrukturOrganisasiPublic'])->name('opd.manage-public');
    Route::post('/profil/tentang-opd/{organization}/manage', [FrontendController::class, 'updateStrukturOrganisasiPublic'])->name('opd.update-public');
    
    // New routes for public official management
    Route::get('/profil/pimpinan/{official}/edit', [FrontendController::class, 'editPimpinanPublic'])->name('pimpinan.edit-public');
    Route::put('/profil/pimpinan/{official}', [FrontendController::class, 'updatePimpinanPublic'])->name('pimpinan.update-public');
});


// Official profile pages (Bupati, Wakil Bupati, Sekda, OPD heads) - must be before generic page routes   

Route::get('/profil/bupati', function () {

    return app(\App\Http\Controllers\OfficialProfileController::class)->show('bupati-sinjai');

})->name('official.bupati');



Route::get('/profil/wakil-bupati', function () {

    return app(\App\Http\Controllers\OfficialProfileController::class)->show('wakil-bupati-sinjai');      

})->name('official.wakil-bupati');



Route::get('/profil/sekretaris-daerah', function () {

    return app(\App\Http\Controllers\OfficialProfileController::class)->show('sekretaris-daerah-sinjai'); 

})->name('official.sekretaris-daerah');



Route::get('/profil/pejabat-daerah', [\App\Http\Controllers\OfficialProfileController::class, 'listKepalaOpd'])->name('official.pejabat-daerah');

// Profil PPID Frontend Route - Placed for correct precedence
Route::get('/profil/ppid', [FrontendController::class, 'showProfilPpid'])->name('frontend.profil-ppid.show');

Route::get('/profil/{slug}', [\App\Http\Controllers\OfficialProfileController::class, 'show'])->name('official.profile.show');





// Specific routes that must come before generic page routes

Route::get('/standar-layanan/{slug}', [App\Http\Controllers\Frontend\StandarLayananController::class, 'showBySlug'])->name('frontend.standar-layanan.showBySlug');

// Route for PDF Flipbook Preview
Route::get('/laporan/ppid/{laporan}/preview', [FrontendController::class, 'previewLaporan'])->name('laporan.ppid.preview');

// Route to serve PDF files securely (bypassing symlink issues)
Route::get('/laporan/{laporan}/file', [FrontendController::class, 'serveLaporanFile'])->name('laporan.file.serve');

// PBJ Public Routes
Route::get('/pbj', [PbjController::class, 'index'])->name('pbj.index');
Route::get('/pbj/{year}', [PbjController::class, 'show'])->name('pbj.show');
Route::post('/pbj/{year}', [PbjController::class, 'store'])->name('pbj.store')->middleware(['auth', 'check.pbj.access']);

// LHKPN Frontend Management
Route::get('/lhkpn/view/{lhkpn}', [LhkpnController::class, 'viewFile'])->name('frontend.lhkpn.view');
Route::get('/lhkpn/{year?}', [LhkpnController::class, 'index'])->name('frontend.lhkpn.index');

// Route for serving storage files with fallback priorities
Route::get('storage/{path}', [App\Http\Controllers\StorageController::class, 'show'])->where('path', '.*')->name('storage.fallback');

// Generic page routes

Route::get('/{page}/{subpage?}', [FrontendController::class, 'page'])->where([

    'page' => '[a-z-]+',

    'subpage' => '[a-z-]+'

])->name('page.show');

Route::get('/standar-layanan/download/{subStandarLayanan}', [App\Http\Controllers\Frontend\StandarLayananController::class, 'download'])->name('frontend.standar-layanan.download');
Route::get('/standar-layanan/visit-url/{subStandarLayanan}', [App\Http\Controllers\Frontend\StandarLayananController::class, 'visitUrl'])->name('frontend.standar-layanan.visit-url');

Route::get('/standar-layanan/file/{subStandarLayanan:slug}', [App\Http\Controllers\Frontend\StandarLayananController::class, 'showFileDetail'])->name('frontend.standar-layanan.file-detail');
