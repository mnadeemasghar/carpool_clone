<?php

use App\Http\Controllers\Api\AddressController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RideController;
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

Route::post('login',[AuthController::class,'login'])->name('login');
// Route::resource('rides',RideController::class)->middleware('auth:sanctum');
Route::get('rides',[RideController::class,'index'])->middleware('auth:sanctum')->name('rides.index');
Route::post('rides',[RideController::class,'store'])->middleware('auth:sanctum')->name('rides.store');
Route::get('rides/my-rides',[RideController::class,'myRides'])->middleware('auth:sanctum')->name('rides.myRides');
Route::resource('addresses',AddressController::class)->middleware('auth:sanctum');

Route::get('get-address', [App\Http\Controllers\AddressController::class, 'getAddress'])->name('getAddress');
