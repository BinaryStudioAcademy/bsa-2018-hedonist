<?php

namespace Hedonist\Providers;

use Hedonist\Repositories\Place\PlaceFeatureRepositoryInterface;
use Hedonist\Repositories\Place\PlaceFeatureRepository;
use Illuminate\Support\ServiceProvider;

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
        $this->app->bind(PlaceFeatureRepositoryInterface::class, PlaceFeatureRepository::class);
    }
}
