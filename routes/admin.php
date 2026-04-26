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
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\SuperadminMiddleware;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

// GRUP ADMIN & SUPERADMIN
Route::middleware(['auth', AdminMiddleware::class])->group(function () {
    
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Informasi CRUD & Similarity
    Route::post('informasi-crud/save', [InformasiController::class, 'store']);
    Route::post('informasi-crud/update/{informasi}', [InformasiController::class, 'update']);
    Route::post('proses-tambah-informasi', [InformasiController::class, 'store'])->name('informasi.stealth_store');
    Route::post('proses-update-informasi/{informasi}', [InformasiController::class, 'update'])->name('informasi.stealth_update');
    Route::post('proses-cek-judul', [InformasiController::class, 'checkSimilarity'])->name('informasi.check_similarity');

    Route::resource('informasi-crud', InformasiController::class)
         ->names('informasi-crud')
         ->parameters(['informasi-crud' => 'informasi']);

    // Resource Dasar
    Route::resource('galeri', GaleriController::class);
    Route::resource('officials', OfficialController::class);
    Route::resource('statistik', StatistikController::class);
    Route::resource('laporan', LaporanController::class);
    Route::resource('standar-layanan', SubStandarLayananController::class);
    Route::resource('permohonan-informasi', PermohonanInformasiController::class);

    // LHKPN & Struktur
    Route::get('my-structure', [StrukturOrganisasiController::class, 'myStructure'])->name('my-structure.manage');
    Route::post('my-structure', [StrukturOrganisasiController::class, 'updateMyStructure'])->name('my-structure.update');
    
    Route::get('lhkpn', [LhkpnController::class, 'index'])->name('lhkpn.index');
    Route::get('lhkpn/create', [LhkpnController::class, 'createForUnit'])->name('lhkpn.create');
    Route::post('lhkpn', [LhkpnController::class, 'storeForUnit'])->name('lhkpn.store');
    Route::delete('lhkpn/{lhkpn}', [LhkpnController::class, 'destroy'])->name('lhkpn.destroy');
});

// KHUSUS SUPERADMIN
Route::middleware(['auth', SuperadminMiddleware::class])->group(function () {
    Route::resource('users', UserController::class);
    Route::resource('profil-ppid', ProfilPpidController::class);
    
    // Sliders & Settings
    Route::resource('sliders', SliderController::class);
    Route::get('slider-settings', [AdminSettingController::class, 'showSliderSettings'])->name('slider-settings.show');
    Route::post('slider-settings', [AdminSettingController::class, 'updateSliderSettings'])->name('slider-settings.update');
    
    // Organisasi & Jabatan (Hierarki)
    Route::resource('organizations', OrganizationController::class);
    Route::resource('organizations.positions', OrganizationPositionController::class);
    
    // Profil Pimpinan & LHKPN Terintegrasi
    Route::resource('officials.lhkpn', LhkpnController::class)->only(['index', 'store', 'destroy']);
    
    // Survei
    Route::resource('surveys', SurveyController::class);
    Route::resource('surveys.questions', SurveyQuestionController::class);
    Route::resource('surveys.responses', SurveyResponseController::class)->only(['index']);
    Route::get('surveys/{survey}/responses/export', [SurveyResponseController::class, 'export'])->name('surveys.responses.export');
    
    // PBJ
    Route::resource('pbj-questions', PbjQuestionController::class);
    Route::post('pbj-questions/duplicate', [PbjQuestionController::class, 'duplicate'])->name('pbj-questions.duplicate');
    Route::delete('pbj-questions/year/{year}', [PbjQuestionController::class, 'deleteYear'])->name('pbj-questions.delete-year');

    // Laporan PPID (Export)
    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('reports/export/total', [ReportController::class, 'exportTotal'])->name('reports.total.export');
    Route::get('reports/export/informasi', [ReportController::class, 'exportInformasi'])->name('reports.informasi.export');
    Route::get('reports/export/permohonan', [ReportController::class, 'exportPermohonan'])->name('reports.permohonan.export');
    Route::get('reports/export/visitors', [ReportController::class, 'exportVisitors'])->name('reports.visitors.export');
    Route::get('reports/export/survey', [ReportController::class, 'exportSurvey'])->name('reports.survey.export');
});

// PEMBERSIH CACHE (Akses: /admin/clear-all-cache)
Route::get('clear-all-cache', function() {
    \Illuminate\Support\Facades\Artisan::call('route:clear');
    \Illuminate\Support\Facades\Artisan::call('view:clear');
    \Illuminate\Support\Facades\Artisan::call('config:clear');
    \Illuminate\Support\Facades\Artisan::call('cache:clear');
    return "Semua cache server telah dibersihkan! Silakan coba buka menu kembali.";
})->middleware(['auth']);
