<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\SurveyController;
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
    
    // RUTE DARURAT: Bersihkan Cache Rute via URL
    // Akses: https://ppidkab.sinjaikab.go.id/v2/admin/clear-route-cache
    Route::get('clear-route-cache', function() {
        \Illuminate\Support\Facades\Artisan::call('route:clear');
        return "Route cache cleared successfully!";
    });
});

// GRUP ADMIN & SUPERADMIN
Route::middleware(['auth', 'verified', AdminMiddleware::class])->group(function () {
    
    // RUTE UNIQUE (Bypass 405 & WAF)
    Route::post('proses-tambah-informasi', [\App\Http\Controllers\Admin\InformasiController::class, 'store'])->name('admin.informasi.stealth_store');
    Route::post('proses-update-informasi/{informasi}', [\App\Http\Controllers\Admin\InformasiController::class, 'update'])->name('admin.informasi.stealth_update');
    Route::post('proses-cek-judul', [\App\Http\Controllers\Admin\InformasiController::class, 'checkSimilarity'])->name('admin.informasi.check_similarity');

    // RUTE RESOURCE
    Route::resource('informasi-crud', \App\Http\Controllers\Admin\InformasiController::class)
         ->names('informasi-crud')
         ->parameters(['informasi-crud' => 'informasi']);

    Route::resource('galeri', \App\Http\Controllers\Admin\GaleriController::class);
    Route::resource('officials', \App\Http\Controllers\Admin\OfficialController::class);
    Route::resource('statistik', \App\Http\Controllers\Admin\StatistikController::class);
    Route::resource('laporan', \App\Http\Controllers\Admin\LaporanController::class);
    Route::resource('standar-layanan', \App\Http\Controllers\Admin\SubStandarLayananController::class);
    
    Route::get('lhkpn', [\App\Http\Controllers\Admin\LhkpnController::class, 'index'])->name('lhkpn.index');
    Route::post('lhkpn', [\App\Http\Controllers\Admin\LhkpnController::class, 'storeForUnit'])->name('lhkpn.store');
    Route::resource('permohonan-informasi', PermohonanInformasiController::class);
});

// KHUSUS SUPERADMIN
Route::middleware(['auth', 'verified', SuperadminMiddleware::class])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    Route::resource('sliders', SliderController::class);
    Route::resource('profil-ppid', ProfilPpidController::class);
    Route::resource('organizations', \App\Http\Controllers\Admin\OrganizationController::class);
});
