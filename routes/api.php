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
        Route::resource('user-list', 'Api\UserList\UserListController')->except([
            'create', 'edit'
        ]);

        Route::namespace('Api\\Places')->group(function() {
            Route::get('places', 'PlaceController@getCollection')->name('getPlaceCollection');
            Route::get('places/{id}', 'PlaceController@getPlace')
                ->where('id', '[0-9]+')
                ->name('getPlace');
            Route::post('places', 'PlaceController@addPlace')->name('addPlace');
            Route::put('places/{id}', 'PlaceController@updatePlace')
                ->where('id', '[0-9]+')
                ->name('updatePlace');
            Route::delete('places/{id}', 'PlaceController@removePlace')
                ->where('id', '[0-9]+')
                ->name('removePlace');
        });

        Route::prefix('reviews')->group(function () {

            Route::get('/', 'Api\Review\ReviewController@getReviewCollection');

            Route::post('/', 'Api\Review\ReviewController@createReview');

            Route::get('/{id}', 'Api\Review\ReviewController@getReview');

            Route::put('/{id}', 'Api\Review\ReviewController@updateReview');

            Route::delete('/{id}', 'Api\Review\ReviewController@deleteReview');
        });
      
        Route::post('/places/{id}/like', 'Api\LikeController@likePlace')->name('place.like');
        Route::post('/places/{id}/dislike', 'Api\DislikeController@dislikePlace')->name('place.dislike');    

        Route::prefix('tastes')->group(function () {
            Route::get('/', 'Api\UserTaste\TasteController@getTastes')
                ->name('tastes.getTastes');
            Route::get('/my', 'Api\User\UserTasteController@getTastes')
                ->name('user.tastes.getTastes');
            Route::post('/my', 'Api\User\UserTasteController@addTaste')
                ->name('user.tastes.addTaste');
            Route::delete('my/{id}', 'Api\User\UserTasteController@deleteTaste')
                ->name('user.tastes.deleteTaste');
        });

        Route::post('/reviews/{id}/like', 'Api\LikeController@likeReview')->name('review.like');
        Route::post('/reviews/{id}/dislike', 'Api\DislikeController@dislikeReview')->name('review.dislike');
        
        Route::post('/user-lists/{id}/attach-place', 'Api\UserList\UserListPlaceController@attachPlace')
            ->name('user-list.place.attach');

        Route::get('/places/features/', 'Api\Places\PlaceFeaturesController@indexPlaceFeature')
            ->name('place.features.indexFeature');

        Route::post('/places/features', 'Api\Places\PlaceFeaturesController@storePlaceFeature')
            ->name('place.features.storeFeature');

        Route::get('/places/features/{id}', 'Api\Places\PlaceFeaturesController@showPlaceFeature')
            ->name('place.features.showFeature');

        Route::delete('/places/features/{id}', 'Api\Places\PlaceFeaturesController@destroyPlaceFeature')
            ->name('place.features.deleteFeature');

    });
});