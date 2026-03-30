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
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->name('admin.')->group(function () {
    // Routes for managing the single structure image per organization for admins
    Route::get('my-structure', [\App\Http\Controllers\Admin\StrukturOrganisasiController::class, 'myStructure'])->name('my-structure.manage');
    Route::post('my-structure', [\App\Http\Controllers\Admin\StrukturOrganisasiController::class, 'updateMyStructure'])->name('my-structure.update');
});

Route::middleware(['auth', 'verified', \App\Http\Middleware\SuperadminMiddleware::class])
->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('sliders', SliderController::class);
    Route::get('slider-settings', [AdminSettingController::class, 'showSliderSettings'])->name('slider-settings.show');
    Route::post('slider-settings', [AdminSettingController::class, 'updateSliderSettings'])->name('slider-settings.update');
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);

    Route::resource('galeri', \App\Http\Controllers\Admin\GaleriController::class);
    Route::resource('informasi', \App\Http\Controllers\Admin\InformasiController::class);
    Route::resource('standar-layanan', \App\Http\Controllers\Admin\SubStandarLayananController::class);

    Route::resource('laporan', \App\Http\Controllers\Admin\LaporanController::class);


    Route::resource('pbj-questions', \App\Http\Controllers\Admin\PbjQuestionController::class);
    Route::post('pbj-questions/duplicate', [\App\Http\Controllers\Admin\PbjQuestionController::class, 'duplicate'])->name('pbj-questions.duplicate');
    Route::delete('pbj-questions/delete-year/{year}', [\App\Http\Controllers\Admin\PbjQuestionController::class, 'deleteYear'])->name('pbj-questions.delete-year');
    
    // LHKPN Routes
    Route::get('lhkpn', [\App\Http\Controllers\Admin\LhkpnController::class, 'index'])->name('lhkpn.index');
    Route::delete('lhkpn/{lhkpn}', [\App\Http\Controllers\Admin\LhkpnController::class, 'destroy'])->name('lhkpn.destroy');
    Route::get('lhkpn/create', [\App\Http\Controllers\Admin\LhkpnController::class, 'createForUnit'])->name('lhkpn.create');
    Route::post('lhkpn', [\App\Http\Controllers\Admin\LhkpnController::class, 'storeForUnit'])->name('lhkpn.store');
    Route::get('officials/{official}/lhkpn/create', [\App\Http\Controllers\Admin\LhkpnController::class, 'createForOfficial'])->name('officials.lhkpn.create');
    Route::post('officials/{official}/lhkpn', [\App\Http\Controllers\Admin\LhkpnController::class, 'storeForOfficial'])->name('officials.lhkpn.store');

    Route::resource('statistik', \App\Http\Controllers\Admin\StatistikController::class);

    Route::middleware([\App\Http\Middleware\SuperadminMiddleware::class])->group(function () {
        Route::resource('organizations', \App\Http\Controllers\Admin\OrganizationController::class);


        // Routes for managing the single structure image per organization
        Route::get('organizations/{organization}/structure', [\App\Http\Controllers\Admin\StrukturOrganisasiController::class, 'manage'])->name('organizations.structure.manage');
        Route::post('organizations/{organization}/structure', [\App\Http\Controllers\Admin\StrukturOrganisasiController::class, 'update'])->name('organizations.structure.update');

        Route::prefix('organizations/{organization}')->name('organizations.positions.')->group(function ()
 {
            Route::get('positions', [\App\Http\Controllers\Admin\OrganizationPositionController::class, 'index'])->name('index');
            Route::get('positions/create', [\App\Http\Controllers\Admin\OrganizationPositionController::class, 'create'])->name('create');
            Route::post('positions', [\App\Http\Controllers\Admin\OrganizationPositionController::class, 'store'])->name('store');
            Route::get('positions/{position}/edit', [\App\Http\Controllers\Admin\OrganizationPositionController::class, 'edit'])->name('edit');
            Route::put('positions/{position}', [\App\Http\Controllers\Admin\OrganizationPositionController::class, 'update'])->name('update');
            Route::delete('positions/{position}', [\App\Http\Controllers\Admin\OrganizationPositionController::class, 'destroy'])->name('destroy');
            Route::post('positions/{position}/assign-member', [\App\Http\Controllers\Admin\OrganizationPositionController::class, 'assignMember'])->name('assign-member');
            Route::delete('positions/{position}/remove-member/{memberId}', [\App\Http\Controllers\Admin\OrganizationPositionController::class, 'removeMember'])->name('remove-member');
        });
        
        Route::post('reorder-positions', [\App\Http\Controllers\Admin\OrganizationPositionController::class, 'reorder'])->name('reorder-positions');
    });

    Route::post('officials/{official}', [\App\Http\Controllers\Admin\OfficialController::class, 'update'])->name('officials.custom_update');

    // Official profile management
    Route::resource('officials', \App\Http\Controllers\Admin\OfficialController::class);
    Route::post('officials/{official}/status', [\App\Http\Controllers\Admin\OfficialController::class, 'updateStatus'])->name('officials.status.update');

    Route::resource('sub-standar-layanan', \App\Http\Controllers\Admin\SubStandarLayananController::class);
    Route::resource('permohonan-informasi', \App\Http\Controllers\Admin\PermohonanInformasiController::class);
    Route::resource('surveys', SurveyController::class);


    Route::resource('surveys.questions', SurveyQuestionController::class)->shallow();
    Route::post('surveys/{survey}/sections', [\App\Http\Controllers\Admin\SurveySectionController::class, 'store'])->name('surveys.sections.store');
    Route::put('sections/{section}', [\App\Http\Controllers\Admin\SurveySectionController::class, 'update'])->name('surveys.sections.update');
    Route::delete('sections/{section}', [\App\Http\Controllers\Admin\SurveySectionController::class, 'destroy'])->name('surveys.sections.destroy');
    
    Route::get('surveys/{survey}/responses/export', [\App\Http\Controllers\Admin\SurveyResponseController::class, 'export'])->name('surveys.responses.export');
    
    Route::resource('profil-ppid', ProfilPpidController::class);
    Route::resource('surveys.responses', SurveyResponseController::class)->only(['index', 'show']);
    Route::post('permohonan-informasi/{permohonan_informasi}/complete', [\App\Http\Controllers\Admin\PermohonanInformasiController::class, 'complete'])->name('permohonan-informasi.complete');
    Route::post('permohonan-informasi/{permohonan_informasi}/reject', [\App\Http\Controllers\Admin\PermohonanInformasiController::class, 'reject'])->name('permohonan-informasi.reject');

    // Report Routes
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\ReportController::class, 'index'])->name('index');
        Route::get('total-export', [\App\Http\Controllers\Admin\ReportController::class, 'exportTotal'])->name('total.export');
        Route::get('informasi-export', [\App\Http\Controllers\Admin\ReportController::class, 'exportInformasi'])->name('informasi.export');
        Route::get('permohonan-export', [\App\Http\Controllers\Admin\ReportController::class, 'exportPermohonan'])->name('permohonan.export');
        Route::get('visitors-export', [\App\Http\Controllers\Admin\ReportController::class, 'exportVisitors'])->name('visitors.export');
        Route::get('survey-export', [\App\Http\Controllers\Admin\ReportController::class, 'exportSurvey'])->name('survey.export');
    });
});
