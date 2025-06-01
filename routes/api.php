<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PengirimController;
use App\Http\Controllers\PenerimaController;
use App\Http\Controllers\PaketController;
use App\Http\Controllers\LaporanPengirimanController;

Route::apiResource('pengirim', PengirimController::class);
Route::get('/pengirim/filter', [PengirimController::class, 'filter']);  // <-- filter route untuk pengirim

Route::apiResource('penerima', PenerimaController::class);
Route::apiResource('paket', PaketController::class);
Route::apiResource('laporan_pengiriman', LaporanPengirimanController::class);

// Filter routes for laporan_pengiriman
Route::get('/laporan_pengiriman/filter/status', [LaporanPengirimanController::class, 'filterByStatus']);
Route::get('/laporan_pengiriman/filter/wilayah', [LaporanPengirimanController::class, 'filterByWilayah']);

// Filter routes for paket
Route::get('/paket/filter/status', [PaketController::class, 'filterByStatus']);
Route::get('/paket/filter/jenis', [PaketController::class, 'filterByJenis']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
