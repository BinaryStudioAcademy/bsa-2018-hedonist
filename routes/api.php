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
    Route::group(['prefix'=>'/auth','namespace'=>'JwtAuth'],function(){

        Route::post('/signup','AuthController@register');

        Route::post('/login','AuthController@login');

        Route::post('/reset','AuthController@reset');

        Route::group(['middleware'=>'jwt.auth'],function(){

            Route::post('/refresh','AuthController@refresh');

            Route::get('/me','AuthController@me');
        });
    });
});