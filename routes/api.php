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
    Route::middleware('auth:api')->get('/user', function (Request $request) {
        return $request->user();
    });
    // routes here
    Route::get('/places/features/', 'Api\Places\PlaceFeaturesController@indexPlaceFeature')
        ->name('place.features.indexFeature');
    Route::post('/places/features', 'Api\Places\PlaceFeaturesController@storePlaceFeature')
        ->name('place.features.storeFeature');
    Route::get('/places/features/{id}', 'Api\Places\PlaceFeaturesController@showPlaceFeature')
        ->name('place.features.showFeature');
    Route::delete('/places/features/{id}', 'Api\Places\PlaceFeaturesController@destroyPlaceFeature')
        ->name('place.features.deleteFeature');
});