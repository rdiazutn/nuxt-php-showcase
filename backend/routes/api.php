<?php

use App\Http\Controllers\Auth\ApiAuthenticationController;
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

Route::middleware('web')->prefix('auth')->group(function () {
    Route::post('login', [ApiAuthenticationController::class, 'login']);
    Route::post('logout', [ApiAuthenticationController::class, 'logout'])->middleware('auth');
    Route::get('user', [ApiAuthenticationController::class, 'user'])->middleware('auth');
});
