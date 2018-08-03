<?php

namespace Tests\Unit\Controllers;

use Tests\TestCase;
use Illuminate\Http\JsonResponse;
use Hedonist\Http\Controllers\ApiController;

class ApiControllerTest extends TestCase
{
    /**
     * @var ApiController
     */
    protected $apiControllerMock;

    protected function setUp()
    {
        $this->apiControllerMock = $this->getMockForAbstractClass(ApiController::class);
    }

    protected function getMethod($name)
    {
        $class = new \ReflectionClass(ApiController::class);
        $method = $class->getMethod($name);
        $method->setAccessible(true);
        return $method;
    }

    public function testSuccessResult()
    {
        $data = ['message' => 'Test message', 'parameter' => 'Test parameter'];
        $statusCode = 200;

        $method = $this->getMethod('successResponse');
        /** @var JsonResponse $result */
        $result = $method->invokeArgs($this->apiControllerMock, [ $data, $statusCode ]);

        $this->assertInstanceOf(JsonResponse::class, $result);

        $object = new \stdClass();
        $object->message = 'Test message';
        $object->parameter = 'Test parameter';
        $this->assertEquals($result->getData(), $object);
        $this->assertEquals($result->getStatusCode(), $statusCode);
    }

    public function testSuccessParamNotAnArray()
    {
        $this->expectException(\TypeError::class);
        $method = $this->getMethod('successResponse');
        $method->invokeArgs($this->apiControllerMock, [ 'Test', 200]);
    }

    public function testSuccessParamStatusCodeNotAnInteger()
    {
        $this->expectException(\TypeError::class);
        $method = $this->getMethod('successResponse');
        $method->invokeArgs($this->apiControllerMock, [ ['Test'], 'String']);
    }

    public function testSuccessArrayIsEmpty()
    {
        $statusCode = 200;
        $method = $this->getMethod('successResponse');
        /** @var JsonResponse $result */
        $result = $method->invokeArgs($this->apiControllerMock, [ [], $statusCode ]);

        $this->assertInstanceOf(JsonResponse::class, $result);
        $this->assertEquals($result->getData(), []);
        $this->assertEquals($result->getStatusCode(), $statusCode);
    }

    public function testErrorResult()
    {
        $data = 'Error message';
        $statusCode = 404;

        $method = $this->getMethod('errorResponse');
        /** @var JsonResponse $result */
        $result = $method->invokeArgs($this->apiControllerMock, [ $data, $statusCode ]);

        $this->assertInstanceOf(JsonResponse::class, $result);
        $errorData = $result->getData();

        $this->assertEquals($errorData->error->httpStatus, $statusCode);
        $this->assertEquals($errorData->error->message, $data);
        $this->assertEquals($result->getStatusCode(), $statusCode);
    }
}
