<?php

namespace Hedonist\Providers;

use Hedonist\Actions\SocialAuth\Manager\SocialAuthStrategyManager;
use Hedonist\Actions\SocialAuth\Manager\SocialAuthStrategyManagerInterface;
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
        $this->app->bind(SocialAuthStrategyManagerInterface::class, SocialAuthStrategyManager::class);
    }
}
