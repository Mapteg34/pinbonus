<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CabinetsController;
use App\Http\Controllers\VkTokenController;
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

Route::group(['middleware' => 'guest:api'], function() {
    Route::post('auth/login', [AuthController::class, 'login']);
    Route::post('auth/register', [AuthController::class, 'register']);
});

Route::group(['middleware' => 'jwt.auth'], function() {
    Route::get('auth/user', [AuthController::class, 'user']);
    Route::post('auth/logout', [AuthController::class, 'logout']);
    Route::post('token', [VkTokenController::class, 'updateToken']);
    Route::get('cabinets', [CabinetsController::class, 'index']);
    Route::get('cabinets/{accountId}', [CabinetsController::class, 'showCabinet']);
    Route::get('cabinets/{accountId}/{campaignId}', [CabinetsController::class, 'showCampaign']);
});

Route::group(['middleware' => 'jwt.refresh'], function() {
    Route::get('auth/refresh', [AuthController::class, 'refresh']);
});
