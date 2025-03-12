<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PengirimController;
use App\Http\Controllers\PenerimaController;
use App\Http\Controllers\PaketController;
use App\Http\Controllers\LaporanPengirimanController;

Route::apiResource('pengirim', PengirimController::class);
Route::apiResource('penerima', PenerimaController::class);
Route::apiResource('paket', PaketController::class);
Route::apiResource('laporan_pengiriman', LaporanPengirimanController::class);
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
