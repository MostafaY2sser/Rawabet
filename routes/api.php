<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});




// get regions by city

    Route::get('/regions', [\App\Http\Controllers\ApiController::class, 'getCitiesFromRegion'])
    ->name('api.cities.byregion');



Route::get('/cities-by-regions', [\App\Http\Controllers\ApiController::class, 'getCitiesFromRegions'])
    ->name('api.cities.byregions');