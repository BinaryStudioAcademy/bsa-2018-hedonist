<?php

namespace Hedonist\Providers;

use Illuminate\Support\ServiceProvider;
use Hedonist\Repositories\User\UserRepository;
use Hedonist\Repositories\User\UserRepositoryInterface;
use Hedonist\Repositories\User\TasteRepository;
use Hedonist\Repositories\User\TasteRepositoryInterface;
use Hedonist\Repositories\User\UserInfoRepository;
use Hedonist\Repositories\User\UserInfoRepositoryInterface;
use Hedonist\Repositories\Place\FavouritePlaceRepository;
use Hedonist\Repositories\Place\FavouritePlaceRepositoryInterface;
use Hedonist\Repositories\Place\PlaceCategoryRepositoryInterface;
use Hedonist\Repositories\Place\PlaceCategoryRepository;
use Hedonist\Repositories\Place\PlaceFeatureRepositoryInterface;
use Hedonist\Repositories\Place\PlaceFeatureRepository;
use Hedonist\Repositories\Place\PlaceRatingRepositoryInterface;
use Hedonist\Repositories\Place\PlaceRatingRepository;
use Hedonist\Repositories\Place\PlaceRepository;
use Hedonist\Repositories\Place\PlaceRepositoryInterface;
use Hedonist\Repositories\Place\CheckinRepository;
use Hedonist\Repositories\Place\CheckinRepositoryInterface;
use Hedonist\Repositories\Dislike\DislikeRepositoryInterface;
use Hedonist\Repositories\Dislike\DislikeRepository;
use Hedonist\Repositories\Like\LikeRepositoryInterface;
use Hedonist\Repositories\Like\LikeRepository;
use Hedonist\Repositories\Review\ReviewPhotoRepository;
use Hedonist\Repositories\Review\ReviewPhotoRepositoryInterface;
use Hedonist\Repositories\Review\ReviewRepositoryInterface;
use Hedonist\Repositories\Review\ReviewRepository;
use Hedonist\Repositories\City\CityRepositoryInterface;
use Hedonist\Repositories\City\CityRepository;
use Hedonist\Repositories\UserList\UserListRepositoryInterface;
use Hedonist\Repositories\UserList\UserListRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(PlaceCategoryRepositoryInterface::class, PlaceCategoryRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(PlaceFeatureRepositoryInterface::class, PlaceFeatureRepository::class);
        $this->app->bind(ReviewRepositoryInterface::class, ReviewRepository::class);
        $this->app->bind(PlaceRepositoryInterface::class, PlaceRepository::class);
        $this->app->bind(FavouritePlaceRepositoryInterface::class, FavouritePlaceRepository::class);
        $this->app->bind(DislikeRepositoryInterface::class, DislikeRepository::class);
        $this->app->bind(LikeRepositoryInterface::class, LikeRepository::class);
        $this->app->bind(PlaceRatingRepositoryInterface::class, PlaceRatingRepository::class);
        $this->app->bind(TasteRepositoryInterface::class, TasteRepository::class);
        $this->app->bind(CityRepositoryInterface::class, CityRepository::class);
        $this->app->bind(UserInfoRepositoryInterface::class, UserInfoRepository::class);
        $this->app->bind(UserListRepositoryInterface::class, UserListRepository::class);
        $this->app->bind(CheckinRepositoryInterface::class, CheckinRepository::class);
        $this->app->bind(ReviewPhotoRepositoryInterface::class, ReviewPhotoRepository::class);
        $this->app->bind(UserInfoRepositoryInterface::class, UserInfoRepository::class);
    }
}
