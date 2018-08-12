<?php

namespace Tests\Unit\Controllers;

use Tests\TestCase;
use Illuminate\Http\JsonResponse;
use Hedonist\Http\Controllers\Api\ApiController;

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
        $result = $method->invokeArgs($this->apiControllerMock, [$data, $statusCode]);

        $this->assertInstanceOf(JsonResponse::class, $result);

        $object = new \stdClass();
        $object->message = 'Test message';
        $object->parameter = 'Test parameter';
        $data = $result->getData();
        $this->assertEquals($data->data, $object);
        $this->assertEquals($data->data->message, 'Test message');
        $this->assertEquals($data->data->parameter, 'Test parameter');
        $this->assertEquals($result->getStatusCode(), $statusCode);
    }

    public function testSuccessDataHasArrayResult()
    {
        $data = [
            ['message' => 'Test message', 'parameter' => 'Test parameter'],
            ['message' => 'Test message1', 'parameter' => 'Test parameter1']
        ];
        $statusCode = 200;

        $method = $this->getMethod('successResponse');
        /** @var JsonResponse $result */
        $result = $method->invokeArgs($this->apiControllerMock, [$data, $statusCode]);

        $this->assertInstanceOf(JsonResponse::class, $result);

        $data = $result->getData();
        $dataToArray = $data->data;
        $this->assertEquals(2, count($dataToArray));
        $this->assertEquals('Test message', $dataToArray[0]->message);
        $this->assertEquals('Test message1', $dataToArray[1]->message);
        $this->assertEquals('Test parameter', $dataToArray[0]->parameter);
        $this->assertEquals('Test parameter1', $dataToArray[1]->parameter);
        $this->assertEquals($result->getStatusCode(), $statusCode);
    }

    public function testSuccessParamNotAnArray()
    {
        $this->expectException(\TypeError::class);
        $method = $this->getMethod('successResponse');
        $method->invokeArgs($this->apiControllerMock, ['Test', 200]);
    }

    public function testSuccessParamStatusCodeNotAnInteger()
    {
        $this->expectException(\TypeError::class);
        $method = $this->getMethod('successResponse');
        $method->invokeArgs($this->apiControllerMock, [['Test'], 'String']);
    }

    public function testSuccessArrayIsEmpty()
    {
        $statusCode = 200;
        $method = $this->getMethod('successResponse');
        /** @var JsonResponse $result */
        $result = $method->invokeArgs($this->apiControllerMock, [[], $statusCode]);

        $this->assertInstanceOf(JsonResponse::class, $result);
        $data = $result->getData();
        $this->assertEquals($data->data, []);
        $this->assertEquals($result->getStatusCode(), $statusCode);
    }

    public function testErrorResult()
    {
        $data = 'Error message';
        $statusCode = 404;

        $method = $this->getMethod('errorResponse');
        /** @var JsonResponse $result */
        $result = $method->invokeArgs($this->apiControllerMock, [$data, $statusCode]);

        $this->assertInstanceOf(JsonResponse::class, $result);
        $errorData = $result->getData();
        $this->assertEquals($errorData->error->httpStatus, $statusCode);
        $this->assertEquals($errorData->error->message, $data);
        $this->assertEquals($result->getStatusCode(), $statusCode);
    }
}
