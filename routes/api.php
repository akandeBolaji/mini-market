<?php

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

Route::prefix('auth')->group(function () {
    Route::group(['middleware' => 'auth:api'], function(){
        Route::get('user', function (Request $request) {
            return $request->user();
        });
    });
});

Route::post('search', 'MarketController@searchMarket')->name('search.markets');

Route::prefix('admin')->group(function () {
    Route::post('login', 'AdminController@login');
    Route::get('refresh', 'AdminController@refresh');
    Route::group(['middleware' => 'auth:api'], function(){
        Route::get('admin', 'AdminController@dashboard');
        Route::post('logout', 'AdminController@logout');
        Route::post('create', 'MarketController@createMarket')->name('create.market');;
        Route::get('get_all', 'MarketController@getAllMarkets')->name('fetch.markets');
    });
});
