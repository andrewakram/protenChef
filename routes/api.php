<?php

use App\Http\Controllers\Api\V1\auth\AuthController;
use App\Http\Controllers\Api\V1\user\HomeController;
use App\Http\Controllers\Api\V1\user\MySubscribersControllers;
use App\Http\Controllers\Api\V1\user\PackagesController;
use App\Http\Controllers\Api\V1\user\LocationsController;
use App\Http\Controllers\Api\V1\user\CouponsController;
use App\Http\Controllers\Api\V1\user\OrderController;
use App\Http\Controllers\Api\V1\app\SettingsController;
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
        Route::get('/settings', [SettingsController::class, 'settings']);
        Route::get('/settings/{key}', [SettingsController::class, 'custom_settings']);
        Route::get('/pages/{type}', [SettingsController::class, 'pages']);
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
            Route::post('/update-profile', [AuthController::class, 'UpdateProfile']);
        });

    });

    Route::group(['prefix' => "user", 'middleware' => 'auth:api'], function () {
        //home
        Route::get('/home', [HomeController::class, 'home']);
        Route::get('/package_types/{package_id}', [PackagesController::class, 'package_types']);
        Route::get('/package_meal_types/{type}/{package_pricec_id}', [PackagesController::class, 'package_meal_types']);
        Route::get('/package_price_details/{package_pricec_id}', [PackagesController::class, 'package_price_details']);
        Route::get('/package_menu_meals', [PackagesController::class, 'package_menu_meals']);
        Route::get('/meal/details/{id}', [PackagesController::class, 'meal_details']);

        //order
        Route::post('/make_order', [OrderController::class, 'make_order']);
        Route::post('/apply/coupon', [OrderController::class, 'apply_coupon']);


        //locations
        Route::get('/locations', [LocationsController::class, 'locations']);
        Route::post('/location/create', [LocationsController::class, 'create']);
        Route::get('/location/delete/{id}', [LocationsController::class, 'delete']);
        Route::get('/location/make_main/{id}', [LocationsController::class, 'make_main']);

//        coupons
        Route::get('/coupons', [CouponsController::class, 'coupons']);

//        subscribtions
        Route::get('/recent-subscribes', [MySubscribersControllers::class, 'RecentSubscribes']);
        Route::get('/previous-subscribes', [MySubscribersControllers::class, 'previousSubscribes']);
        //order details
        Route::get('/order-details/{order_id}/{meal_type_id?}', [MySubscribersControllers::class, 'OrderDetails']);
        //order details
        Route::get('/cancel-order/{order_id}', [MySubscribersControllers::class, 'cancelOrder']);
        Route::get('/order-days/{order_id}', [MySubscribersControllers::class, 'OrderDays']);
        Route::post('/freeze-day', [MySubscribersControllers::class, 'freezeDay']);

    });

    Route::get('/unauthrized', [AuthController::class, 'unauthrized'])->name('login');

});
