<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Grouping Throttle 60 request/minute
Route::group(['middleware' => ['throttle:2000,1']], function () { 
	Route::post('kendaraan_masuk', 'App\Http\Controllers\PetugasParkirController@kendaraan_masuk');
	Route::post('kendaraan_keluar', 'App\Http\Controllers\PetugasParkirController@kendaraan_keluar');
	Route::post('kendaraan_data', 'App\Http\Controllers\PetugasParkirController@kendaraan_data');
});

