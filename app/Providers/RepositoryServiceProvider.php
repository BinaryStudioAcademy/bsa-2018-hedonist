<?php

namespace Hedonist\Providers;

use Hedonist\Repositories\User\UserRepository;
use Hedonist\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use Hedonist\Repositories\Place\{PlaceCategoryRepositoryInterface,PlaceCategoryRepository};

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
        $this->app->bind(UserRepositoryInterface::class,UserRepository::class);
        //:end-bindings:
    }
}
