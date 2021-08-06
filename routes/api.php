<?php

use App\Http\Controllers\DistrictController;
use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\RegencyController;
use App\Http\Controllers\VillageController;
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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('province', [ProvinceController::class, 'search']);
Route::get('regency', [RegencyController::class, 'search']);
Route::get('district', [DistrictController::class, 'search']);
Route::get('village', [VillageController::class, 'search']);
Route::get('zipcode/{zipcode}', [VillageController::class, 'zipcode']);
