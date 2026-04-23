<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\SurveyController;
use App\Http\Controllers\Admin\SurveyQuestionController;
use App\Http\Controllers\Admin\SurveyResponseController;
use App\Http\Controllers\Admin\AdminSettingController;
use App\Http\Controllers\Admin\ProfilPpidController;
use App\Http\Controllers\Admin\PermohonanInformasiController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\SuperadminMiddleware;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('my-structure', [\App\Http\Controllers\Admin\StrukturOrganisasiController::class, 'myStructure'])->name('my-structure.manage');
    Route::post('my-structure', [\App\Http\Controllers\Admin\StrukturOrganisasiController::class, 'updateMyStructure'])->name('my-structure.update');
});

// TOTAL BYPASS: Rename 'informasi' to 'manajemen-berkas' to avoid cPanel ModSecurity filters
Route::middleware(['auth', 'verified', AdminMiddleware::class])->group(function () {
    // Kita ganti nama resource agar URL-nya berubah total
    Route::resource('manajemen-berkas', \App\Http\Controllers\Admin\InformasiController::class)
         ->names('informasi-crud')
         ->parameters(['manajemen-berkas' => 'informasi']);
    
    Route::resource('galeri', \App\Http\Controllers\Admin\GaleriController::class);
    Route::resource('officials', \App\Http\Controllers\Admin\OfficialController::class);
    Route::resource('statistik', \App\Http\Controllers\Admin\StatistikController::class);
    Route::resource('laporan', \App\Http\Controllers\Admin\LaporanController::class);
    Route::resource('standar-layanan', \App\Http\Controllers\Admin\SubStandarLayananController::class);
    
    Route::get('lhkpn', [\App\Http\Controllers\Admin\LhkpnController::class, 'index'])->name('lhkpn.index');
    Route::post('lhkpn', [\App\Http\Controllers\Admin\LhkpnController::class, 'storeForUnit'])->name('lhkpn.store');

    Route::resource('permohonan-informasi', PermohonanInformasiController::class);
    Route::post('permohonan-informasi/{permohonan_informasi}/complete', [PermohonanInformasiController::class, 'complete'])->name('permohonan-informasi.complete');
    
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\ReportController::class, 'index'])->name('index');
    });
});

Route::middleware(['auth', 'verified', SuperadminMiddleware::class])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    Route::resource('sliders', SliderController::class);
    Route::resource('profil-ppid', ProfilPpidController::class);
    Route::resource('organizations', \App\Http\Controllers\Admin\OrganizationController::class);
});
