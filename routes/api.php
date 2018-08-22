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

        Route::get('/unique', 'AuthController@checkEmailUnique');

        Route::get('/me', 'AuthController@me')->middleware('custom.jwt.auth');

        Route::post('/reset-password', 'AuthController@changePassword');

        Route::group(['prefix' => '/social'], function () {
            Route::get('/{provider}/redirect', 'SocialAuthController@redirect');

            Route::get('/{provider}/callback', 'SocialAuthController@oauthCallback');
        });
    });

    Route::group(['middleware' => 'custom.jwt.auth'], function () {
        Route::get('/users/{user_id}/lists', 'Api\User\UserList\UserListController@userLists')
            ->name('user-list.lists');

        Route::resource('user-list', 'Api\User\UserList\UserListController')->except([
            'create', 'edit'
        ]);


        Route::namespace('Api\\Place')->group(function () {
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

            Route::post('/{id}/like', 'Api\Like\LikeController@likeReview')->name('review.like');
            Route::post('/{id}/dislike', 'Api\Like\DislikeController@dislikeReview')->name('review.dislike');
        });

        Route::post('/places/{id}/like', 'Api\Like\LikeController@likePlace')->name('place.like');
        Route::post('/places/{id}/dislike', 'Api\Like\DislikeController@dislikePlace')->name('place.dislike');
        Route::get('/places/{id}/liked', 'Api\Like\LikeController@getLikedPlace')->name('place.liked');

        Route::get('/places/{id}/rating', 'Api\Place\PlaceRatingController@getPlaceRatingAvg')
            ->name('place.rating.getPlaceRatingAvg');

        Route::prefix('tastes')->group(function () {
            Route::get('/', 'Api\User\UserTaste\TasteController@getTastes')
                ->name('tastes.getTastes');
            Route::get('/my', 'Api\User\UserTasteController@getTastes')
                ->name('user.tastes.getTastes');
            Route::post('/my', 'Api\User\UserTasteController@addTaste')
                ->name('user.tastes.addTaste');
            Route::delete('my/{id}', 'Api\User\UserTasteController@deleteTaste')
                ->name('user.tastes.deleteTaste');
        });

        Route::post('/user-lists/{id}/attach-place', 'Api\User\UserList\UserListPlaceController@attachPlace')
            ->name('user-list.place.attach');

        Route::get('/places/features/', 'Api\Place\PlaceFeaturesController@indexPlaceFeature')
            ->name('place.features.indexFeature');

        Route::post('/places/features', 'Api\Place\PlaceFeaturesController@storePlaceFeature')
            ->name('place.features.storeFeature');

        Route::get('/places/features/{id}', 'Api\Place\PlaceFeaturesController@showPlaceFeature')
            ->name('place.features.showFeature');

        Route::delete('/places/features/{id}', 'Api\Place\PlaceFeaturesController@destroyPlaceFeature')
            ->name('place.features.deleteFeature');

        Route::get('/users/{userId}/info/', 'Api\User\UserInfoController@show')
            ->name('user.info.show');
        Route::put('/users/{userId}/info/', 'Api\User\UserInfoController@update')
            ->name('user.info.update');

        Route::post('/users/me/checkins', 'Api\Place\PlaceCheckinController@setCheckin')
            ->name('user.me.checkin');
        Route::get('/users/me/checkins', 'Api\Place\PlaceCheckinController@getUserCheckInCollection')
            ->name('user.me.getUserCheckins');

        Route::post('/places/rating', 'Api\Place\PlaceRatingController@setRating')
            ->name('place.rating.setPlaceRating');

        Route::get('/places/rating/byPlaceUser', 'Api\Place\PlaceRatingController@getRating')
            ->name('place.rating.getPlaceRatingByPlaceUser');

        Route::get('/places/rating/{id}', 'Api\Place\PlaceRatingController@getRating')
            ->name('place.rating.getPlaceRating');

        Route::resource('/places/categories', 'Api\Place\PlaceCategoryController')->except([
            'create', 'edit'
        ]);

        Route::get('/places/categories/{id}/tags', 'Api\Place\PlaceCategoryTagsController@getTagsByCategoryId');

        Route::post('/places/categories/search', 'Api\Place\PlaceCategoryController@getPlaceCategoryByName');
    });
});