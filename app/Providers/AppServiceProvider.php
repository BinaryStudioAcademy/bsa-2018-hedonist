<?php

namespace Hedonist\Providers;

use Hedonist\Services\UserList\UserListService;
use Hedonist\Services\UserList\UserListServiceInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserListServiceInterface::class, UserListService::class);
    }
}
