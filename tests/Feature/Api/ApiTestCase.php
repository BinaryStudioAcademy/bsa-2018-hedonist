<?php

namespace Tests\Feature\Api;

use Tests\TestCase;

/**
 * Class ApiTestCase
 * @package Tests\Feature\Api
 */
abstract class ApiTestCase extends TestCase
{
    const GET = 'GET';
    const POST = 'POST';
    const PUT = 'PUT';
    const PATCH = 'PUT';
    const DELETE = 'DELETE';

    abstract public function testGet();
    abstract public function testPost();
    abstract public function testPut();
    abstract public function testDelete();

    abstract protected function getApiClass() : string;
    abstract protected function getEndpoint() : string;

    protected function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * Check if response is json with a structure and status 200
     * @param string $uri
     * @param string $apiType
     * @param array $jsonStructure
     */
    protected function isSuccessJsonResponse($uri, $apiType, $jsonStructure)
    {
        $this->json($apiType, $uri)
            ->assertHeader('Content-Type', 'application/json')
            ->assertStatus(200)
            ->assertJsonStructure($jsonStructure);
    }

    /**
     * Check if response return status 404
     * @param string $uri
     * @param string $apiType
     */
    protected function isNotExistingResponse($uri, $apiType)
    {
        $this->json($apiType, $uri)->assertStatus(404);
    }
}
