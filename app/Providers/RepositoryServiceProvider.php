<?php

namespace Hedonist\Providers;

use Illuminate\Support\ServiceProvider;
use Hedonist\Repositories\Place\{FavouritePlaceRepository,
    FavouritePlaceRepositoryInterface,
    PlaceCategoryRepositoryInterface,
    PlaceCategoryRepository,
    PlaceFeatureRepositoryInterface,
    PlaceFeatureRepository};

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
        $this->app->bind(PlaceFeatureRepositoryInterface::class, PlaceFeatureRepository::class);
        $this->app->bind(FavouritePlaceRepositoryInterface::class, FavouritePlaceRepository::class);
    }
}
