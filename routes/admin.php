<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\SurveyController;
use App\Http\Controllers\Admin\SurveyQuestionController;
use App\Http\Controllers\Admin\SurveyResponseController;
use App\Http\Controllers\Admin\AdminSettingController;
use App\Http\Controllers\Admin\ProfilPpidController;

/*
|--------------------------------------------------------------------------
| Admin Routes (Loaded via bootstrap/app.php with 'admin' prefix and 'admin.' name)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {
    // Routes for managing the single structure image per organization for admins
    Route::get('my-structure', [\App\Http\Controllers\Admin\StrukturOrganisasiController::class, 'myStructure'])->name('my-structure.manage');
    Route::post('my-structure', [\App\Http\Controllers\Admin\StrukturOrganisasiController::class, 'updateMyStructure'])->name('my-structure.update');
});

Route::middleware(['auth', 'verified', \App\Http\Middleware\SuperadminMiddleware::class])->group(function () {
    // Dashboard (ONLY SUPERADMIN)
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Resources
    Route::resource('sliders', SliderController::class);
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    Route::resource('galeri', \App\Http\Controllers\Admin\GaleriController::class);
    Route::resource('informasi', \App\Http\Controllers\Admin\InformasiController::class);
    Route::resource('standar-layanan', \App\Http\Controllers\Admin\SubStandarLayananController::class);
    Route::resource('laporan', \App\Http\Controllers\Admin\LaporanController::class);
    Route::resource('statistik', \App\Http\Controllers\Admin\StatistikController::class);
    Route::resource('officials', \App\Http\Controllers\Admin\OfficialController::class);
    Route::resource('surveys', SurveyController::class);
    Route::resource('surveys.sections', \App\Http\Controllers\Admin\SurveySectionController::class)->shallow();
    Route::resource('profil-ppid', ProfilPpidController::class);
    Route::resource('surveys.questions', SurveyQuestionController::class)->shallow();
    Route::resource('surveys.responses', SurveyResponseController::class)->only(['index', 'show']);

    // Additional Settings
    Route::get('slider-settings', [AdminSettingController::class, 'showSliderSettings'])->name('slider-settings.show');
    Route::post('slider-settings', [AdminSettingController::class, 'updateSliderSettings'])->name('slider-settings.update');

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

    // Organizations & Positions (Strictly Superadmin)
    Route::middleware([\App\Http\Middleware\SuperadminMiddleware::class])->group(function () {
        Route::resource('organizations', \App\Http\Controllers\Admin\OrganizationController::class);
        Route::get('organizations/{organization}/structure', [\App\Http\Controllers\Admin\StrukturOrganisasiController::class, 'manage'])->name('organizations.structure.manage');
        Route::post('organizations/{organization}/structure', [\App\Http\Controllers\Admin\StrukturOrganisasiController::class, 'update'])->name('organizations.structure.update');
        Route::get('organizations/{organization}/positions', [\App\Http\Controllers\Admin\OrganizationPositionController::class, 'index'])->name('organizations.positions.index');
        Route::post('reorder-positions', [\App\Http\Controllers\Admin\OrganizationPositionController::class, 'reorder'])->name('reorder-positions');
    });

    // Official Actions
    Route::post('officials/{official}/status', [\App\Http\Controllers\Admin\OfficialController::class, 'updateStatus'])->name('officials.status.update');

    // Permohonan
    Route::resource('permohonan-informasi', \App\Http\Controllers\Admin\PermohonanInformasiController::class);
    Route::post('permohonan-informasi/{permohonan_informasi}/complete', [\App\Http\Controllers\Admin\PermohonanInformasiController::class, 'complete'])->name('permohonan-informasi.complete');
    Route::post('permohonan-informasi/{permohonan_informasi}/reject', [\App\Http\Controllers\Admin\PermohonanInformasiController.class, 'reject'])->name('permohonan-informasi.reject');
    Route::post('permohonan-response/{response}/resend', [\App\Http\Controllers\Admin\PermohonanInformasiController.class, 'resendNotification'])->name('permohonan-response.resend');


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
