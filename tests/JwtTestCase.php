<?php

namespace Tests;

use Hedonist\Entities\User\User;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;

class JwtTestCase extends TestCase
{
    protected $user;

    /**
     * @deprecated use actingWithToken() of tests/Feature/Api/ApiTestCase.php instead
     */
    public function actingAs(UserContract $user, $driver = null) : self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @deprecated use tests/Feature/Api/ApiTestCase.php instead
     */
    public function call($method, $uri, $parameters = [], $cookies = [], $files = [], $server = [], $content = null)
    {
        if ($this->user) {
            $server['HTTP_AUTHORIZATION'] = 'Bearer ' . auth()->login($this->user);
        }

        $server['HTTP_ACCEPT'] = 'application/json';

        return parent::call($method, $uri, $parameters, $cookies, $files, $server, $content);
    }

    /**
     * @deprecated use actingWithToken() of tests/Feature/Api/ApiTestCase.php instead
     */
    protected function actingAsJwtToken()
    {
        return $this->actingAs(factory(User::class)->create());
    }
}