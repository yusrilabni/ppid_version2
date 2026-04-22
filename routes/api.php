<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\OfficialController;
use App\Http\Controllers\Api\BeritaController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\InformasiController;
use App\Http\Controllers\Api\LaporanController;
use App\Http\Controllers\Api\PermohonanInformasiController;
use App\Http\Controllers\Api\SliderController;
use App\Http\Controllers\Api\GaleriController;
use App\Http\Controllers\Api\StatistikController;
use App\Http\Controllers\Api\MenuController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\HealthController;

Route::prefix("v1")->group(function () {
    Route::get("/home", [App\Http\Controllers\Api\HomeController::class, "index"]);
    Route::get("/profile", [ProfileController.class, "index"]);
    Route::get("/categories", [CategoryController::class, "index"]);
    Route::get("/berita", [BeritaController::class, "index"]);
    Route::get("/berita/{slug}", [BeritaController::class, "show"]);
    Route::get("/officials", [OfficialController::class, "index"]);
    Route::get("/officials/{slug}", [OfficialController::class, "show"]);
    Route::get("/informasi", [InformasiController::class, "index"]);
    Route::get("/laporan", [LaporanController::class, "index"]);
    Route::post("/permohonan", [PermohonanInformasiController::class, "store"]);
    Route::get("/permohonan/status/{code}", [PermohonanInformasiController::class, "checkStatus"]);
    Route::get("/sliders", [SliderController::class, "index"]);
    Route::get("/galeri", [GaleriController::class, "index"]);
    Route::get("/menu", [MenuController::class, "index"]);
    Route::get("/statistik", [StatistikController::class, "index"]);
    Route::get("/health", [HealthController::class, "index"]);
    Route::post("/login", [LoginController::class, "login"]);
    Route::post("/contact", [ContactController::class, "store"]);

    Route::middleware("auth:sanctum")->group(function () {
        Route::get("/user", function (Request $request) {
            return $request->user();
        });
    });
});

Route::get("/health", [HealthController::class, "index"]);
Route::post("/telegram/webhook", [\App\Http\Controllers\Api\TelegramWebhookController::class, "handle"]);
