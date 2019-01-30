<?php

use App\Http\Controllers\AdsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AccountsController;
use App\Http\Controllers\CampaignsController;
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

Route::post('auth/login', [AuthController::class, 'login']);

Route::group(['middleware' => 'jwt.auth'], function() {
    Route::get('auth/user', [AuthController::class, 'user']);
    Route::post('auth/logout', [AuthController::class, 'logout']);
    Route::get('accounts', [AccountsController::class, 'index']);
    Route::get('accounts/{accountId}', [AccountsController::class, 'show']);
    Route::get('campaigns/{accountId}', [CampaignsController::class, 'index']);
    Route::get('campaigns/{accountId}/{campaignId}', [CampaignsController::class, 'show']);
    Route::get('ads/{accountId}/{campaignId}', [AdsController::class, 'index']);
    Route::patch('ads/{accountId}/{campaignId}/{adId}', [AdsController::class, 'update']);
    Route::delete('ads/{accountId}/{campaignId}/{adId}', [AdsController::class, 'destroy']);
});

Route::group(['middleware' => 'jwt.refresh'], function() {
    Route::get('auth/refresh', [AuthController::class, 'refresh']);
});
