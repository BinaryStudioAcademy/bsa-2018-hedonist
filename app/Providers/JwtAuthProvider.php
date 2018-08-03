<?php

namespace Hedonist\Providers;


use Hedonist\Repositories\User\UserRepository;
use Hedonist\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class JwtAuthProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(UserRepositoryInterface::class,UserRepository::class);
    }
}