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

Route::middleware(['auth'])->group(function () {
    Route::get('my-structure', [\App\Http\Controllers\Admin\StrukturOrganisasiController::class, 'myStructure'])->name('my-structure.manage');
    Route::post('my-structure', [\App\Http\Controllers\Admin\StrukturOrganisasiController::class, 'updateMyStructure'])->name('my-structure.update');
    
    // RUTE PEMBERSIH TOTAL (Jalankan jika masih error)
    Route::get('clear-all-cache', function() {
        \Illuminate\Support\Facades\Artisan::call('route:clear');
        \Illuminate\Support\Facades\Artisan::call('view:clear');
        \Illuminate\Support\Facades\Artisan::call('config:clear');
        return "Semua cache (Route, View, Config) telah dibersihkan!";
    });
});

// GRUP ADMIN & SUPERADMIN
Route::middleware(['auth', AdminMiddleware::class])->group(function () {
    
    // DASHBOARD SEKARANG BISA DIAKSES ADMIN & SUPERADMIN
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // JALAN PINTAS: Daftarkan URL yang tersangkut di cache agar tetap bisa upload
    Route::post('informasi-crud/save', [\App\Http\Controllers\Admin\InformasiController::class, 'store']);
    Route::post('informasi-crud/update/{informasi}', [\App\Http\Controllers\Admin\InformasiController::class, 'update']);
    
    // RUTE RESMI (Sesuai kode terbaru)
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
Route::middleware(['auth', SuperadminMiddleware::class])->group(function () {
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    Route::resource('sliders', SliderController::class);
    Route::resource('profil-ppid', ProfilPpidController::class);
    Route::resource('organizations', \App\Http\Controllers\Admin\OrganizationController::class);
});
