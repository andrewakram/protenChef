<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Route::group([
    'prefix' => 'admin',
    'namespace' => 'App\Http\Controllers'
], function () {

    Route::group(['middleware' => 'auth:admin'], function () {
        Route::get('home', 'HomeController@index')->name('home');
    });

    Route::group(['namespace' => 'Admin','as' => 'admin'], function () {
        Route::get('login', 'AuthController@login_view')->name('login-view');
        Route::post('login', 'AuthController@login')->name('.login');
        Route::get('logout', 'AuthController@logout')->name('.logout');

        Route::group(['middleware' => 'auth:admin'], function () {
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
        });

    });
});
