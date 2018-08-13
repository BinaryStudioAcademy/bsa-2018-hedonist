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
    Route::group(['prefix' => '/auth', 'namespace' => 'Api\\Auth'], function () {
        Route::post('/signup', 'AuthController@register');

        Route::post('/login', 'AuthController@login');

        Route::post('/logout', 'AuthController@logout');

        Route::post('/reset', 'AuthController@resetPassword');

        Route::post('/recover', 'AuthController@recoverPassword');

        Route::post('/refresh', 'AuthController@refresh');

        Route::get('/me', 'AuthController@me')->middleware('custom.jwt.auth');

        Route::post('/reset-password', 'AuthController@changePassword');
    });

    Route::group(['middleware' => 'custom.jwt.auth'], function () {
        Route::resource('user-list', 'Api\UserList\UserListController')->except([
            'create', 'edit'
        ]);

        Route::namespace('Api\\Places')->group(function () {
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

            Route::get('/{id}/photos', 'Api\Review\ReviewController@getPhotosByReviewId');
            Route::post('/photos', 'Api\Review\ReviewPhotoController@upload')->name('review.photo.upload');
            Route::delete('/photos/{id}', 'Api\Review\ReviewPhotoController@destroy')->name('review.photo.destroy');

            Route::post('/{id}/like', 'Api\LikeController@likeReview')->name('review.like');
            Route::post('/{id}/dislike', 'Api\DislikeController@dislikeReview')->name('review.dislike');
        });

        Route::post('/places/{id}/like', 'Api\LikeController@likePlace')->name('place.like');
        Route::post('/places/{id}/dislike', 'Api\DislikeController@dislikePlace')->name('place.dislike');

        Route::get('/places/{id}/rating', 'Api\Places\PlaceRatingController@getPlaceRatingAvg')
            ->name('place.rating.getPlaceRatingAvg');

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

        Route::get('/users/{userId}/info/', 'Api\Users\UserInfoController@show')
            ->name('user.info.show');
        Route::put('/users/{userId}/info/', 'Api\Users\UserInfoController@update')
            ->name('user.info.update');
      
        Route::post('/users/me/checkins', 'Api\Places\PlaceCheckinController@setCheckin')
            ->name('user.me.checkin');

        Route::get('/users/me/lists', 'Api\UserList\UserListController@index')
            ->name('user.me.lists');

        Route::post('/places/rating', 'Api\Places\PlaceRatingController@setRating')
            ->name('place.rating.setPlaceRating');

        Route::get('/places/rating/byPlaceUser', 'Api\Places\PlaceRatingController@getRating')
            ->name('place.rating.getPlaceRatingByPlaceUser');

        Route::get('/places/rating/{id}', 'Api\Places\PlaceRatingController@getRating')
            ->name('place.rating.getPlaceRating');

        /* Routes here.. */
    });
});