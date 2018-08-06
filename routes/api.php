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
    Route::group(['prefix'=>'/auth','namespace'=>'Api'],function(){

        Route::post('/signup','AuthController@register');

        Route::post('/login','AuthController@login');

        Route::post('/logout','AuthController@logout');

        Route::post('/reset','AuthController@resetPassword');

        Route::post('/recover','AuthCOntroller@recoverPassword');

        Route::group(['middleware'=>'jwt.auth'],function(){

            Route::post('/refresh','AuthController@refresh');

            Route::get('/me','AuthController@me');
        });
    });

    Route::namespace('Api')->group(function() {
        Route::get('places', 'PlaceController@getCollection')->name('getPlaceCollection');
        Route::get('places/{id}', 'PlaceController@getPlace')->name('getPlace');
        Route::post('places', 'PlaceController@addPlace')->name('addPlace');
        Route::put('places/{id}', 'PlaceController@updatePlace')->name('updatePlace');
        Route::delete('places/{id}', 'PlaceController@removePlace')->name('removePlace');
    });
});