<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\KategoriApiController;
use App\Http\Controllers\Api\BarangApiController;
use App\Http\Controllers\Api\BarangMasukApiController;
use App\Http\Controllers\Api\BarangKeluarApiController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//Menampilkan api kategori dengan method : apiResource pada class KategoriApiController
Route::apiResource('kategori', KategoriApiController::class);

//Menampilkan api barang dengan method : apiResource pada class BarangApiController
Route::apiResource('barang', BarangApiController::class);

//Menampilkan api barangmasuk dengan method : apiResource pada class BarangMasukApiController
Route::apiResource('barangmasuk', BarangMasukApiController::class);

//Menampilkan api barangkeluar dengan method : apiResource pada class BarangMKeluarApiController
Route::apiResource('barangkeluar', BarangKeluarApiController::class);


