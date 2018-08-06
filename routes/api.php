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

Route::prefix('v1')->group(function () {
    Route::middleware('auth:api')->get('/user', function (Request $request) {
        return $request->user();
    });

    Route::namespace('Api')->group(function() {
        Route::get('places', 'PlaceController@getCollection')->name('getPlaceCollection');
        Route::get('places/{id}', 'PlaceController@getPlace')->name('getPlace');
        Route::post('places', 'PlaceController@addPlace')->name('addPlace');
        Route::put('places/{id}', 'PlaceController@updatePlace')->name('updatePlace');
        Route::delete('places/{id}', 'PlaceController@removePlace')->name('removePlace');
    });
});