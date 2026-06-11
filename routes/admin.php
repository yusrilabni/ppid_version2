<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\SurveyController;
use App\Http\Controllers\Admin\AdminSettingController;
use App\Http\Controllers\Admin\ProfilPpidController;
use App\Http\Controllers\Admin\PermohonanInformasiController;
use App\Http\Controllers\Admin\LhkpnController;
use App\Http\Controllers\Admin\OrganizationController;
use App\Http\Controllers\Admin\OrganizationPositionController;
use App\Http\Controllers\Admin\PbjQuestionController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\InformasiController;
use App\Http\Controllers\Admin\GaleriController;
use App\Http\Controllers\Admin\OfficialController;
use App\Http\Controllers\Admin\StatistikController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\SubStandarLayananController;
use App\Http\Controllers\Admin\StrukturOrganisasiController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SurveyQuestionController;
use App\Http\Controllers\Admin\SurveyResponseController;
use App\Http\Controllers\Admin\SurveySectionController;
use App\Http\Controllers\Admin\BeritaController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\SuperadminMiddleware;

/*
|--------------------------------------------------------------------------
| Admin Routes (EXPLICIT NAMING TO BYPASS CACHE ISSUES)
|--------------------------------------------------------------------------
*/

// GRUP ADMIN & SUPERADMIN
Route::middleware(['auth', AdminMiddleware::class])->group(function () {
    
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Informasi CRUD
    Route::post('informasi-crud/save', [InformasiController::class, 'store'])->name('informasi-crud.save');
    Route::post('proses-tambah-informasi', [InformasiController::class, 'store'])->name('informasi.stealth_store');
    Route::post('proses-update-informasi/{informasi}', [InformasiController::class, 'update'])->name('informasi.stealth_update');
    Route::post('proses-cek-judul', [InformasiController::class, 'checkSimilarity'])->name('informasi.check_similarity');

    Route::resource('informasi-crud', InformasiController::class)
         ->names('informasi-crud')
         ->parameters(['informasi-crud' => 'informasi']);

    // Resource Dasar
    Route::post('galeri/{galeri}/toggle-pin', [GaleriController::class, 'togglePin'])->name('galeri.toggle-pin');
    Route::resource('galeri', GaleriController::class);
    Route::resource('berita', BeritaController::class);
    Route::resource('officials', OfficialController::class);
    Route::resource('statistik', StatistikController::class);
    Route::resource('laporan', LaporanController::class);
    Route::resource('standar-layanan', SubStandarLayananController::class);
    Route::resource('permohonan-informasi', PermohonanInformasiController::class);
    Route::post('permohonan-informasi/{permohonan_informasi}/complete', [PermohonanInformasiController::class, 'complete'])->name('permohonan-informasi.complete');
    Route::post('permohonan-informasi/{permohonan_informasi}/reject', [PermohonanInformasiController::class, 'reject'])->name('permohonan-informasi.reject');
    Route::post('permohonan-response/{response}/resend', [PermohonanInformasiController::class, 'resendNotification'])->name('permohonan-response.resend');

    // LHKPN
    Route::get('lhkpn', [LhkpnController::class, 'index'])->name('lhkpn.index');
    Route::get('lhkpn/create', [LhkpnController::class, 'createForUnit'])->name('lhkpn.create');
    Route::post('lhkpn', [LhkpnController::class, 'storeForUnit'])->name('lhkpn.store');
    Route::delete('lhkpn/{lhkpn}', [LhkpnController::class, 'destroy'])->name('lhkpn.destroy');
    
    // Struktur Internal
    Route::get('my-structure', [StrukturOrganisasiController::class, 'myStructure'])->name('my-structure.manage');
    Route::post('my-structure', [StrukturOrganisasiController::class, 'updateMyStructure'])->name('my-structure.update');
});

// KHUSUS SUPERADMIN
Route::middleware(['auth', SuperadminMiddleware::class])->group(function () {
    Route::resource('users', UserController::class);
    // Redis Monitoring
    Route::get('/redis-check', [App\Http\Controllers\Admin\RedisMonitorController::class, 'check'])->name('redis.check');

    Route::resource('profil-ppid', ProfilPpidController::class);
    
    // Sliders & Settings
    Route::resource('sliders', SliderController::class);
    Route::get('slider-settings', [AdminSettingController::class, 'showSliderSettings'])->name('slider-settings.show');
    Route::post('slider-settings', [AdminSettingController::class, 'updateSliderSettings'])->name('slider-settings.update');
    
    // Organisasi & Jabatan (Explicit)
    Route::resource('organizations', OrganizationController::class);
    Route::get('organizations/{organization}/positions', [OrganizationPositionController::class, 'index'])->name('organizations.positions.index');
    Route::get('organizations/{organization}/positions/create', [OrganizationPositionController::class, 'create'])->name('organizations.positions.create');
    Route::post('organizations/{organization}/positions', [OrganizationPositionController::class, 'store'])->name('organizations.positions.store');
    Route::get('positions/{position}/edit', [OrganizationPositionController::class, 'edit'])->name('positions.edit');
    Route::put('positions/{position}', [OrganizationPositionController::class, 'update'])->name('positions.update');
    Route::delete('positions/{position}', [OrganizationPositionController::class, 'destroy'])->name('positions.destroy');
    
    // Profil Pimpinan LHKPN
    Route::resource('officials.lhkpn', LhkpnController::class)->only(['index', 'store', 'destroy']);
    
    // SURVEI (EXPLICIT TOTAL)
    Route::get('surveys', [SurveyController::class, 'index'])->name('surveys.index');
    Route::get('surveys/create', [SurveyController::class, 'create'])->name('surveys.create');
    Route::post('surveys', [SurveyController::class, 'store'])->name('surveys.store');
    Route::get('surveys/{survey}', [SurveyController::class, 'show'])->name('surveys.show');
    Route::get('surveys/{survey}/edit', [SurveyController::class, 'edit'])->name('surveys.edit');
    Route::put('surveys/{survey}', [SurveyController::class, 'update'])->name('surveys.update');
    Route::delete('surveys/{survey}', [SurveyController::class, 'destroy'])->name('surveys.destroy');

    // Survey Sections (Flat)
    Route::post('surveys/{survey}/sections', [SurveySectionController::class, 'store'])->name('surveys.sections.store');
    Route::put('surveys/sections/{section}', [SurveySectionController::class, 'update'])->name('surveys.sections.update');
    Route::delete('surveys/sections/{section}', [SurveySectionController::class, 'destroy'])->name('surveys.sections.destroy');

    // Survey Questions (Explicit Nested Names to match View)
    Route::post('surveys/{survey}/questions/reorder', [SurveyQuestionController::class, 'reorder'])->name('surveys.questions.reorder');
    Route::get('surveys/{survey}/questions/create', [SurveyQuestionController::class, 'create'])->name('surveys.questions.create');
    Route::post('surveys/{survey}/questions', [SurveyQuestionController::class, 'store'])->name('surveys.questions.store');
    Route::get('surveys/{survey}/questions/{question}/edit', [SurveyQuestionController::class, 'edit'])->name('surveys.questions.edit');
    Route::put('surveys/{survey}/questions/{question}', [SurveyQuestionController::class, 'update'])->name('surveys.questions.update');
    Route::delete('surveys/{survey}/questions/{question}', [SurveyQuestionController::class, 'destroy'])->name('surveys.questions.destroy');
    
    // Survey Responses
    Route::get('surveys/{survey}/responses', [SurveyResponseController::class, 'index'])->name('surveys.responses.index');
    Route::get('surveys/{survey}/responses/export', [SurveyResponseController::class, 'export'])->name('surveys.responses.export');
    Route::post('surveys/{survey}/responses/process-report', [SurveyResponseController::class, 'exportExcel'])->name('surveys.responses.exportExcel');
    
    // PBJ
    Route::resource('pbj-questions', PbjQuestionController::class);
    Route::post('pbj-questions/duplicate', [PbjQuestionController::class, 'duplicate'])->name('pbj-questions.duplicate');
    Route::delete('pbj-questions/year/{year}', [PbjQuestionController::class, 'deleteYear'])->name('pbj-questions.delete-year');

    // Laporan (Explicit)
    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('reports/export/total', [ReportController::class, 'exportTotal'])->name('reports.total.export');
    Route::get('reports/export/informasi', [ReportController::class, 'exportInformasi'])->name('reports.informasi.export');
    Route::get('reports/export/permohonan', [ReportController::class, 'exportPermohonan'])->name('reports.permohonan.export');
    Route::get('reports/export/visitors', [ReportController::class, 'exportVisitors'])->name('reports.visitors.export');
    Route::get('reports/export/survey', [ReportController::class, 'exportSurvey'])->name('reports.survey.export');
});

// CACHE BUSTER SAKTI (HANYA SUPERADMIN)
Route::get('clear-all-cache', function() {
    \Illuminate\Support\Facades\Artisan::call('route:clear');
    \Illuminate\Support\Facades\Artisan::call('view:clear');
    \Illuminate\Support\Facades\Artisan::call('config:clear');
    \Illuminate\Support\Facades\Artisan::call('cache:clear');
    return "BERHASIL! Semua rute telah diperbarui secara paksa. Silakan coba buka menu kembali.";
})->middleware(['auth', SuperadminMiddleware::class]);
