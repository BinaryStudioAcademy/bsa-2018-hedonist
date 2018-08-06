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
    Route::group(['prefix' => '/auth', 'namespace' => 'Api'], function() {

        Route::post('/signup','AuthController@register');

        Route::post('/login','AuthController@login');

        Route::post('/logout','AuthController@logout');

        Route::post('/reset','AuthController@resetPassword');

        Route::post('/recover','AuthCOntroller@recoverPassword');

        Route::group(['middleware' => 'jwt.auth'], function() {

            Route::post('/refresh', 'AuthController@refresh');

            Route::get('/me', 'AuthController@me');
        });
    });

    Route::group(['middleware' => 'jwt.auth'], function() {

        Route::post('/places/rates', 'Api\Places\PlaceRatingController@setRating')
            ->name('place.rates.setRating');
        Route::get('/places/rates/place/{id}', 'Api\Places\PlaceRatingController@getPlaceRatingAvg')
            ->name('place.rates.getPlaceRatingAvg');
        Route::get('/places/rates/{id}', 'Api\Places\PlaceRatingController@getRating')
            ->name('place.rates.getRating');

        /* Routes here.. */
    });
});
