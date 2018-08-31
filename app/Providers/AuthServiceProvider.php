<?php

namespace Hedonist\Providers;

use Hedonist\Entities\UserList\UserList;
use Hedonist\Policies\UserListPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'Hedonist\Model' => 'Hedonist\Policies\ModelPolicy',
        UserList::class => UserListPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('delete', UserListPolicy::class . '@delete');
        Gate::define('update', UserListPolicy::class . '@update');
    }
}
