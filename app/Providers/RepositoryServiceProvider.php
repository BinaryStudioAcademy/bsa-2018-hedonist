<?php

namespace Hedonist\Providers;

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
        $this->app->bind(\App\Repositories\PlaceCategoryRepositoryInterface::class, \App\Repositories\PlaceCategoryRepository::class);
        //:end-bindings:
    }
}
