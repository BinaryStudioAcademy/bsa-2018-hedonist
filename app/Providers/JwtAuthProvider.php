<?php

namespace Hedonist\Providers;


use Hedonist\Actions\Auth\LoginUserActionInterface;
use Hedonist\Actions\Auth\RegisterUserAction;
use Hedonist\Actions\Auth\RegisterUserActionInterface;
use Hedonist\Actions\LoginUserAction;
use Hedonist\Repositories\User\UserRepository;
use Hedonist\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class JwtAuthProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->bind(RegisterUserActionInterface::class,RegisterUserAction::class);
        $this->app->bind(LoginUserActionInterface::class, LoginUserAction::class);
    }

    public function register()
    {
        $this->app->singleton(UserRepositoryInterface::class,UserRepository::class);
    }
}