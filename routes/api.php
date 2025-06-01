<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PengirimController;
use App\Http\Controllers\PenerimaController;
use App\Http\Controllers\PaketController;
use App\Http\Controllers\LaporanPengirimanController;
use App\Http\Controllers\AuthController;

// === AUTH ROUTES ===
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// === PROTECTED ROUTES ===
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Resource routes
    Route::apiResource('pengirim', PengirimController::class);
    Route::get('/pengirim/filter', [PengirimController::class, 'filter']);

    Route::apiResource('penerima', PenerimaController::class);
    Route::apiResource('paket', PaketController::class);
    Route::apiResource('laporan_pengiriman', LaporanPengirimanController::class);

    // Filter routes for laporan_pengiriman
    Route::get('/laporan_pengiriman/filter/status', [LaporanPengirimanController::class, 'filterByStatus']);
    Route::get('/laporan_pengiriman/filter/wilayah', [LaporanPengirimanController::class, 'filterByWilayah']);

    // Filter routes for paket
    Route::get('/paket/filter/status', [PaketController::class, 'filterByStatus']);
    Route::get('/paket/filter/jenis', [PaketController::class, 'filterByJenis']);
});
