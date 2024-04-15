<?php

use App\Http\Controllers\API\ProvinsiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// ----------------------- REST API Provinsi --------------------------//
Route::controller(ProvinsiController::class)->group(function () {
    Route::get('provinsi', 'lihatProvinsi');
    Route::get('provinsi/{id}', 'detailProvinsi');
    Route::post('provinsi', 'tambahProvinsi');
    Route::put('provinsi/{id}', 'perbaharuiProvinsi');
    Route::delete('provinsi/{id}', 'hapusProvinsi');
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});