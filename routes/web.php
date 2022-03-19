<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\ZoneController;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
//    return view('welcome');
    return redirect()->route('admin.login');
//    return redirect()->route('home');
});


Route::get('cache', function () {
    Artisan::call('config:cache');
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    return 'success';
});


Route::group([
    'prefix' => 'admin',
    'namespace' => 'App\Http\Controllers'
], function () {

    Route::group(['middleware' => 'auth:admin'], function () {
        Route::get('home', 'HomeController@index')->name('home');
    });

    Route::group(['namespace' => 'Admin', 'as' => 'admin'], function () {
        Route::get('login', 'AuthController@login_view')->name('login-view');
        Route::post('login', 'AuthController@login')->name('.login');
        Route::get('logout', 'AuthController@logout')->name('.logout');

        Route::group(['middleware' => 'auth:admin'], function () {

            Route::group(['prefix' => 'users', 'as' => '.users'], function () {
                Route::get('/', 'UserController@index');
                Route::get('/profile', 'ProfileController@profile')->name('.profile');
                Route::get('getData', 'UserController@getData')->name('.datatable');
                Route::get('/create', 'UserController@create')->name('.create');
                Route::post('/store', 'UserController@store')->name('.store');
                Route::get('/edit/{id}', 'UserController@edit')->name('.edit');
                Route::post('/update', 'UserController@update')->name('.update');
                Route::get('/show/{id}', 'UserController@show')->name('.show');
                Route::post('/delete', 'UserController@delete')->name('.delete');
                Route::post('/delete-multi', 'UserController@deleteMulti')->name('.deleteMulti');
                Route::get('/orders/{id}', 'UserController@userOrders')->name('.orders');
                Route::get('/getUserOrdersData/{id}', 'UserController@getUserOrdersData')->name('.ordersDatatable');
            });

            Route::group(['prefix' => 'admins', 'as' => '.admins'], function () {
                Route::get('/', 'AdminController@index');
                Route::get('getData', 'AdminController@getData')->name('.datatable');
                Route::get('/create', 'AdminController@create')->name('.create');
                Route::post('/store', 'AdminController@store')->name('.store');
                Route::get('/edit/{id}', 'AdminController@edit')->name('.edit');
                Route::post('/update', 'AdminController@update')->name('.update');
                Route::get('/show/{id}', 'AdminController@show')->name('.show');
                Route::post('/delete', 'AdminController@delete')->name('.delete');
                Route::post('/delete-multi', 'AdminController@deleteMulti')->name('.deleteMulti');
            });

            Route::group(['prefix' => 'orders', 'as' => '.orders'], function () {
                Route::get('/{status}', 'OrderController@index');
                Route::get('getData/{status}', 'OrderController@getData')->name('.datatable');
                Route::get('/create', 'OrderController@create')->name('.create');
                Route::post('/store', 'OrderController@store')->name('.store');
                Route::get('/edit/{id}', 'OrderController@edit')->name('.edit');
                Route::post('/update', 'OrderController@update')->name('.update');
                Route::get('/show/{id}', 'OrderController@show')->name('.show');
                Route::post('/delete', 'OrderController@delete')->name('.delete');
                Route::post('/delete-multi', 'OrderController@deleteMulti')->name('.deleteMulti');
            });

            Route::group(['prefix' => 'pages', 'as' => '.pages'], function () {
                Route::get('/{type}', 'PageController@index');
                Route::get('getData/{type}', 'PageController@getData')->name('.datatable');
                Route::get('/create/{type}', 'PageController@create')->name('.create');
                Route::post('/store', 'PageController@store')->name('.store');
                Route::get('/edit/{type}', 'PageController@edit')->name('.edit');
                Route::post('/update', 'PageController@update')->name('.update');
                Route::get('/show/{id}', 'PageController@show')->name('.show');
                Route::post('/delete', 'PageController@delete')->name('.delete');
                Route::post('/delete-multi', 'PageController@deleteMulti')->name('.deleteMulti');
            });

            Route::group(['prefix' => 'screens', 'as' => '.screens'], function () {
                Route::get('/', 'ScreenController@index');
                Route::get('getData', 'ScreenController@getData')->name('.datatable');
                Route::get('/create', 'ScreenController@create')->name('.create');
                Route::post('/store', 'ScreenController@store')->name('.store');
                Route::get('/edit/{id}', 'ScreenController@edit')->name('.edit');
                Route::post('/update', 'ScreenController@update')->name('.update');
                Route::get('/show/{id}', 'ScreenController@show')->name('.show');
                Route::post('/delete', 'ScreenController@delete')->name('.delete');
                Route::post('/delete-multi', 'ScreenController@deleteMulti')->name('.deleteMulti');
            });

            Route::group(['prefix' => 'sliders', 'as' => '.sliders'], function () {
                Route::get('/', 'SliderController@index');
                Route::get('getData', 'SliderController@getData')->name('.datatable');
                Route::get('/create', 'SliderController@create')->name('.create');
                Route::post('/store', 'SliderController@store')->name('.store');
                Route::get('/edit/{id}', 'SliderController@edit')->name('.edit');
                Route::post('/update', 'SliderController@update')->name('.update');
                Route::get('/show/{id}', 'SliderController@show')->name('.show');
                Route::post('/delete', 'SliderController@delete')->name('.delete');
                Route::post('/delete-multi', 'SliderController@deleteMulti')->name('.deleteMulti');
            });

            Route::group(['prefix' => 'offers', 'as' => '.offers'], function () {
                Route::get('/', 'OfferController@index');
                Route::get('getData', 'OfferController@getData')->name('.datatable');
                Route::get('/create', 'OfferController@create')->name('.create');
                Route::post('/store', 'OfferController@store')->name('.store');
                Route::get('/edit/{id}', 'OfferController@edit')->name('.edit');
                Route::post('/update', 'OfferController@update')->name('.update');
                Route::get('/show/{id}', 'OfferController@show')->name('.show');
                Route::post('/delete', 'OfferController@delete')->name('.delete');
                Route::post('/delete-multi', 'OfferController@deleteMulti')->name('.deleteMulti');
            });

            Route::group(['prefix' => 'coupons', 'as' => '.coupons'], function () {
                Route::get('/', 'CouponController@index');
                Route::get('getData', 'CouponController@getData')->name('.datatable');
                Route::get('/create', 'CouponController@create')->name('.create');
                Route::post('/store', 'CouponController@store')->name('.store');
                Route::get('/edit/{id}', 'CouponController@edit')->name('.edit');
                Route::post('/update', 'CouponController@update')->name('.update');
                Route::get('/show/{id}', 'CouponController@show')->name('.show');
                Route::post('/delete', 'CouponController@delete')->name('.delete');
                Route::post('/delete-multi', 'CouponController@deleteMulti')->name('.deleteMulti');
            });

            Route::group(['prefix' => 'notifications', 'as' => '.notifications'], function () {
                Route::get('/', 'NotificationController@index');
                Route::get('getData', 'NotificationController@getData')->name('.datatable');
                Route::get('/create', 'NotificationController@create')->name('.create');
                Route::post('/store', 'NotificationController@store')->name('.store');
                Route::get('/edit/{id}', 'NotificationController@edit')->name('.edit');
                Route::post('/update', 'NotificationController@update')->name('.update');
                Route::get('/show/{id}', 'NotificationController@show')->name('.show');
                Route::post('/delete', 'NotificationController@delete')->name('.delete');
                Route::post('/delete-multi', 'NotificationController@deleteMulti')->name('.deleteMulti');
            });

            Route::group(['prefix' => 'meal-types', 'as' => '.meal-types'], function () {
                Route::get('/{type}', 'MealTypeController@index');
                Route::get('getData/{type}', 'MealTypeController@getData')->name('.datatable');
                Route::get('/create/{type}', 'MealTypeController@create')->name('.create');
                Route::post('/store', 'MealTypeController@store')->name('.store');
                Route::get('/edit/{id}', 'MealTypeController@edit')->name('.edit');
                Route::post('/update', 'MealTypeController@update')->name('.update');
                Route::get('/show/{id}', 'MealTypeController@show')->name('.show');
                Route::post('/delete', 'MealTypeController@delete')->name('.delete');
                Route::post('/delete-multi', 'MealTypeController@deleteMulti')->name('.deleteMulti');
            });

            Route::group(['prefix' => 'meals', 'as' => '.meals'], function () {
                Route::get('/{meal_type_id}', 'MealController@index');
                Route::get('getData/{meal_type_id}', 'MealController@getData')->name('.datatable');
                Route::get('/create', 'MealController@create')->name('.create');
                Route::post('/store', 'MealController@store')->name('.store');
                Route::get('/edit/{id}', 'MealController@edit')->name('.edit');
                Route::post('/update', 'MealController@update')->name('.update');
                Route::get('/show/{id}', 'MealController@show')->name('.show');
                Route::post('/delete', 'MealController@delete')->name('.delete');
                Route::post('/delete-multi', 'MealController@deleteMulti')->name('.deleteMulti');
            });

            Route::group(['prefix' => 'packages', 'as' => '.packages'], function () {
                Route::get('/', 'PackageController@index');
                Route::get('getData', 'PackageController@getData')->name('.datatable');
                Route::get('/create', 'PackageController@create')->name('.create');
                Route::post('/store', 'PackageController@store')->name('.store');
                Route::get('/edit/{id}', 'PackageController@edit')->name('.edit');
                Route::post('/update', 'PackageController@update')->name('.update');
                Route::get('/show/{id}', 'PackageController@show')->name('.show');
                Route::post('/delete', 'PackageController@delete')->name('.delete');
                Route::post('/delete-multi', 'PackageController@deleteMulti')->name('.deleteMulti');
            });

            Route::group(['prefix' => 'package-types', 'as' => '.package-types'], function () {
                Route::get('/', 'PackageTypeController@index');
                Route::get('getData', 'PackageTypeController@getData')->name('.datatable');
                Route::get('/create', 'PackageTypeController@create')->name('.create');
                Route::post('/store', 'PackageTypeController@store')->name('.store');
                Route::get('/edit/{id}', 'PackageTypeController@edit')->name('.edit');
                Route::post('/update', 'PackageTypeController@update')->name('.update');
                Route::get('/show/{id}', 'PackageTypeController@show')->name('.show');
                Route::post('/delete', 'PackageTypeController@delete')->name('.delete');
                Route::post('/delete-multi', 'PackageTypeController@deleteMulti')->name('.deleteMulti');
            });

            Route::group(['prefix' => 'package-type-prices', 'as' => '.package-type-prices'], function () {
                Route::get('/{package_id}', 'PackageTypePriceController@index');
                Route::get('getData/{package_id}', 'PackageTypePriceController@getData')->name('.datatable');
                Route::get('/create', 'PackageTypePriceController@create')->name('.create');
                Route::post('/store', 'PackageTypePriceController@store')->name('.store');
                Route::get('/edit/{id}', 'PackageTypePriceController@edit')->name('.edit');
                Route::post('/update', 'PackageTypePriceController@update')->name('.update');
                Route::get('/show/{id}', 'PackageTypePriceController@show')->name('.show');
                Route::post('/delete', 'PackageTypePriceController@delete')->name('.delete');
                Route::post('/delete-multi', 'PackageTypePriceController@deleteMulti')->name('.deleteMulti');
            });

            Route::group(['prefix' => 'settings', 'as' => '.settings'], function () {
                Route::get('/edit', [SettingController::class, 'index']);
                Route::post('/update', [SettingController::class, 'update'])->name('.update');
                Route::group(['prefix' => 'zones', 'as' => '.zones'], function () {
                    Route::get('/', [ZoneController::class, 'index']);
                    Route::get('getData', [ZoneController::class, 'getData'] )->name('.datatable');
                    Route::post('/store', [ZoneController::class, 'store'])->name('.store');
                    Route::get('get-all-zone-cordinates/{id?}', [ZoneController::class, 'get_all_zone_cordinates'])->name('.zoneCoordinates');
                    Route::post('search', [ZoneController::class, 'search'] )->name('.search');

                    Route::get('/edit/{id}', [ZoneController::class, 'edit'])->name('.edit');
                    Route::post('/update/{id}', [ZoneController::class, 'update'])->name('.update');

                    Route::post('/delete',  [ZoneController::class, 'delete'])->name('.delete');

                });
            });
        });

    });
});
