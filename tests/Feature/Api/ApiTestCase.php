<?php

namespace Tests\Feature\Api;

use Tests\TestCase;

/**
 * Class ApiTestCase
 * @package Tests\Feature\Api
 */
abstract class ApiTestCase extends TestCase
{
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
