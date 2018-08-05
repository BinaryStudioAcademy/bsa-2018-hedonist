<?php

use Illuminate\Http\Request;

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

            // routes here
            Route::post('/v1/places/rates', 'Api\Places\RatesController@setRate')
                ->name('place.rates.setRate');
            Route::get('/v1/places/rates/place/{id}', 'Api\Places\RatesController@getPlaceRateAvg')
                ->name('place.rates.getPlaceRateAvg');
            Route::get('/v1/places/rates/{id}', 'Api\Places\RatesController@getRate')
                ->name('place.rates.getRate');
        });
    });
});