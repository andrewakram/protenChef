<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\HomeController;
use App\Http\Controllers\Api\V1\PackagesController;
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

//should login first authorization
Route::group(['prefix' => "V1", 'namespace' => 'V1'], function () {
    Route::group(['prefix' => "app"], function () {
        //main screens
        Route::get('/screens', [HomeController::class, 'screens']);
        Route::get('/settings', [HomeController::class, 'settings']);
    });
    Route::group(['prefix' => "auth"], function () {
        //auth
        Route::post('/login', [AuthController::class, 'login']);
        Route::post('/sign-up', [AuthController::class, 'SignUp']);
        Route::post('/verify', [AuthController::class, 'Verify']);
        Route::post('/resend-code', [AuthController::class, 'resendCode']);
        Route::post('/forget-password', [AuthController::class, 'ForgetPassword']);
        Route::group(['middleware' => 'auth:api'], function () {
            Route::post('/change-password', [AuthController::class, 'changePassword']);
        });

    });

    Route::group(['prefix' => "user", 'middleware' => 'auth:api'], function () {
        //home
        Route::get('/home', [HomeController::class, 'home']);
        Route::get('/package_types/{package_id}', [PackagesController::class, 'package_types']);

    });

    Route::get('/unauthrized', [AuthController::class, 'unauthrized'])->name('login');

});
