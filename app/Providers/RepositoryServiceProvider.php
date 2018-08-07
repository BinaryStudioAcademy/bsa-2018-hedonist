<?php

namespace Hedonist\Providers;

use Illuminate\Support\ServiceProvider;
use Hedonist\Repositories\User\{
    UserRepository,
    UserRepositoryInterface
};
use Hedonist\Repositories\Place\{
    FavouritePlaceRepository,
    FavouritePlaceRepositoryInterface,
    PlaceCategoryRepositoryInterface,
    PlaceCategoryRepository,
    PlaceFeatureRepositoryInterface,
    PlaceFeatureRepository
};
use Hedonist\Repositories\Dislike\{
    DislikeRepositoryInterface,
    DislikeRepository
};
use Hedonist\Repositories\Like\{
    LikeRepositoryInterface,
    LikeRepository
};
use Hedonist\Repositories\City\{
    CityRepositoryInterface,
    CityRepository
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
        $this->app->bind(FavouritePlaceRepositoryInterface::class, FavouritePlaceRepository::class);
        $this->app->bind(DislikeRepositoryInterface::class, DislikeRepository::class);
        $this->app->bind(LikeRepositoryInterface::class, LikeRepository::class);
        $this->app->bind(CityRepositoryInterface::class, CityRepository::class);
    }
}
