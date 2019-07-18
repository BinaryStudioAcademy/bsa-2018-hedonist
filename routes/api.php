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

        Route::post('/language', 'AuthController@changeLanguage');

        Route::group(['prefix' => '/social'], function () {
            Route::get('/{provider}/redirect', 'SocialAuthController@redirect');

            Route::get('/{provider}/callback', 'SocialAuthController@oauthCallback');
        });
    });

    Route::group(['middleware' => 'custom.jwt.auth'], function () {
        Route::delete('/users/{id}', 'Api\Auth\AuthController@deleteUser');

        Route::group(['namespace' => 'Api\User'], function () {
            Route::get('/notifications', 'UserNotificationsController@getNotifications');
            Route::get('/notifications/unread', 'UserNotificationsController@getUnreadNotifications');
            Route::put('/notifications/read', 'UserNotificationsController@readNotifications');
            Route::delete('/notifications', 'UserNotificationsController@deleteNotifications');
        });

        Route::get('/users/{user_id}/lists', 'Api\User\UserList\UserListController@userLists')
            ->name('user-list.lists');

        Route::resource('user-lists', 'Api\User\UserList\UserListController')->except([
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

            Route::get('/places/search', 'PlaceController@searchByFilters');

            Route::get('/places/autocomplete/search', 'PlaceController@getCollectionForAutocomplete');

            Route::post('/place/add-taste', 'PlaceController@addTaste');

            Route::get('/places/recommendations/{id}', 'PlaceController@getRecommendationPlaceCollection');
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

            Route::get('/{id}/users-liked', 'Api\Review\ReviewController@getUsersWhoLikedReview');
            Route::get('/{id}/users-disliked', 'Api\Review\ReviewController@getUsersWhoDislikedReview');

            Route::get('/photos/{placeId}', 'Api\Review\ReviewController@getReviewPhotosByPlaceId');
        });

        Route::post('/places/{id}/like', 'Api\Like\LikeController@likePlace')->name('place.like');
        Route::post('/places/{id}/dislike', 'Api\Like\DislikeController@dislikePlace')->name('place.dislike');
        Route::get('/places/{id}/liked', 'Api\Like\LikeController@getLikedPlace')->name('place.liked');

        Route::post('/places/{id}/ratings', 'Api\Place\PlaceRatingController@setRating')
            ->name('place.rating.setPlaceRating');

        Route::get('/places/{id}/ratings/avg', 'Api\Place\PlaceRatingController@getPlaceRatingAvg')
            ->name('place.rating.getPlaceRatingAvg');

        Route::prefix('tastes')->group(function () {
            Route::get('/', 'Api\User\UserTaste\TasteController@getTastes')
                ->name('tastes.getTastes');
            Route::get('/autocomplete', 'Api\User\UserTaste\TasteController@getTastesAutocomplete')
                ->name('taste.getTastesAutocomplete');
            Route::post('/custom', 'Api\User\UserTaste\TasteController@addTaste')
                ->name('tastes.addCustomTaste');
            Route::delete('/custom/{id}', 'Api\User\UserTaste\TasteController@deleteTaste')
                ->name('tastes.deleteCustomTaste');
            Route::get('/my', 'Api\User\UserTasteController@getTastes')
                ->name('user.tastes.getTastes');
            Route::post('/my', 'Api\User\UserTasteController@addTaste')
                ->name('user.tastes.addTaste');
            Route::delete('my/{id}', 'Api\User\UserTasteController@deleteTaste')
                ->name('user.tastes.deleteTaste');
        });

        Route::prefix('user-lists')->group(function () {
            Route::post('/favourite', 'Api\User\UserList\UserListPlaceController@attachPlaceToFavourite')
                ->name('lists.favourite.attach');
            Route::post('/{id}/attach-place', 'Api\User\UserList\UserListPlaceController@attachPlace')
                ->name('user-list.place.attach');

            Route::post('/{id}/detach-place', 'Api\User\UserList\UserListPlaceController@detachPlace')
                ->name('user-list.place.detach');

            Route::delete('/{id}/image', 'Api\User\UserList\UserListController@deleteImage');
        });

        Route::get('/places/features/', 'Api\Place\PlaceFeaturesController@indexPlaceFeature')
            ->name('place.features.indexFeature');

        Route::post('/places/features', 'Api\Place\PlaceFeaturesController@storePlaceFeature')
            ->name('place.features.storeFeature');

        Route::get('/places/features/{id}', 'Api\Place\PlaceFeaturesController@showPlaceFeature')
            ->name('place.features.showFeature');

        Route::delete('/places/features/{id}', 'Api\Place\PlaceFeaturesController@destroyPlaceFeature')
            ->name('place.features.deleteFeature');

        Route::get('/users/{userId}/profile', 'Api\User\UserInfoController@show')
            ->name('user.info.show');
        Route::post('/users/{userId}/profile', 'Api\User\UserInfoController@update')
            ->name('user.info.update');
        Route::delete('/users/{userId}/profile/avatar', 'Api\User\UserInfoController@deleteAvatar');

        Route::post('/users/me/checkins', 'Api\Place\PlaceCheckinController@setCheckin')
            ->name('user.me.checkin');
        Route::get('/users/me/checkins', 'Api\Place\PlaceCheckinController@getUserCheckInCollection')
            ->name('user.me.getUserCheckins');

        Route::post('/users/{id}/followers', 'Api\User\UserFollowsController@followUser');
        Route::delete('/users/{id}/followers', 'Api\User\UserFollowsController@unfollowUser');

        Route::get('/users/{id}/followers', 'Api\User\UserFollowsController@getFollowers');
        Route::get('/users/{id}/followed', 'Api\User\UserFollowsController@getFollowedUsers');

        Route::get('/places/categories/search', 'Api\Place\PlaceCategoryController@getPlaceCategoryByName');

        Route::resource('/places/categories', 'Api\Place\PlaceCategoryController')->except([
            'create', 'edit'
        ]);

        Route::get('/places/categories/{id}/tags', 'Api\Place\TagsController@getTagsByCategoryId');

        Route::get('/users/{userId}/reviews', 'Api\Review\ReviewController@getReviewsWithPlaceByUserId');
    });
});
