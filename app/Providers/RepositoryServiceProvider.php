<?php

namespace Hedonist\Providers;

use Illuminate\Support\ServiceProvider;
use Hedonist\Repositories\User\{
    UserRepository,
    UserRepositoryInterface,
    TasteRepository,
    TasteRepositoryInterface,
    UserInfoRepository,
    UserInfoRepositoryInterface
};
use Hedonist\Repositories\Place\{
    FavouritePlaceRepository,
    FavouritePlaceRepositoryInterface,
    PlaceCategoryRepositoryInterface,
    PlaceCategoryRepository,
    PlaceFeatureRepositoryInterface,
    PlaceFeatureRepository,
    PlacePhotoRepository,
    PlacePhotoRepositoryInterface,
    PlaceRatingRepositoryInterface,
    PlaceRatingRepository,
    PlaceRepository,
    PlaceRepositoryInterface,
    CheckinRepository,
    CheckinRepositoryInterface
};
use Hedonist\Repositories\Dislike\{
    DislikeRepositoryInterface,
    DislikeRepository
};
use Hedonist\Repositories\Like\{
    LikeRepositoryInterface,
    LikeRepository
};
use Hedonist\Repositories\Review\{
    ReviewPhotoRepository,
    ReviewPhotoRepositoryInterface,
    ReviewRepositoryInterface,
    ReviewRepository
};
use Hedonist\Repositories\City\{
    CityRepositoryInterface,
    CityRepository
};
use Hedonist\Repositories\UserList\{
    UserListRepositoryInterface,
    UserListRepository
};

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
        $this->app->bind(PlacePhotoRepositoryInterface::class, PlacePhotoRepository::class);
    }
}
