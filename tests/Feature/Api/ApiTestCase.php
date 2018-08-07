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
    protected $jwtToken;

    public function call($method, $uri, $parameters = [], $cookies = [], $files = [], $server = [], $content = null) : TestResponse
    {
        if ($this->jwtToken) {
            $server['HTTP_AUTHORIZATION'] = 'Bearer ' . $this->jwtToken;
        }
        $server['HTTP_ACCEPT'] = 'application/json';
        return parent::call($method, $uri, $parameters, $cookies, $files, $server, $content);
    }

    protected function authenticate(UserContract $user): void
    {
        $this->jwtToken = auth()->login($user);
    }

    protected function actingWithToken(UserContract $user = null, $driver = 'api') : self
    {
        $user = $user ? $user : factory(User::class)->create();
        $this->authenticate($user);
        return $this->actingAs($user, $driver);
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
