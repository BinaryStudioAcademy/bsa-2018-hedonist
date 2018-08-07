<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\TestResponse;
use Tests\TestCase;
use Hedonist\Entities\User\User;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;

/**
 * Class ApiTestCase
 * @package Tests\Feature\Api
 */
abstract class ApiTestCase extends TestCase
{
    protected $authenticatedUser;

    public function actingAs(UserContract $user, $driver = null) : self
    {
        $this->authenticatedUser = $user;
        return $this;
    }

    public function call($method, $uri, $parameters = [], $cookies = [], $files = [], $server = [], $content = null) : TestResponse
    {
        if ($this->authenticatedUser) {
            $server['HTTP_AUTHORIZATION'] = 'Bearer ' . auth()->login($this->authenticatedUser);
        }
        $server['HTTP_ACCEPT'] = 'application/json';
        return parent::call($method, $uri, $parameters, $cookies, $files, $server, $content);
    }

    protected function actingAsJwtToken() : self
    {
        return $this->actingAs(factory(User::class)->create());
    }

    protected function assertSuccessJsonResponse(string $uri, string $apiType, array $jsonStructure)
    {
        $this->json($apiType, $uri)
            ->assertHeader('Content-Type', 'application/json')
            ->assertStatus(200)
            ->assertJsonStructure($jsonStructure);
    }

    protected function assertNotFoundJsonResponse(string $uri, string $apiType)
    {
        $this->json($apiType, $uri)->assertStatus(404);
    }
}