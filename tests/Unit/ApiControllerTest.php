<?php

namespace Tests\Unit;

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

    public function testSuccessResult()
    {
        $data = ['message' => 'Test message', 'parameter' => 'Test parameter'];
        $statusCode = 200;

        /** @var JsonResponse $result */
        $result = $this->apiControllerMock->successResponse($data, $statusCode);

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
        $this->apiControllerMock->successResponse('Test', 200);
    }

    public function testSuccessParamStatusCodeNotAnInteger()
    {
        $this->expectException(\TypeError::class);
        $this->apiControllerMock->successResponse(['Test'], 'String');
    }

    public function testSuccessArrayIsEmpty()
    {
        $statusCode = 200;
        $result = $this->apiControllerMock->successResponse([], $statusCode);

        $this->assertInstanceOf(JsonResponse::class, $result);
        $this->assertEquals($result->getData(), []);
        $this->assertEquals($result->getStatusCode(), $statusCode);
    }

    public function testErrorResult()
    {
        $data = ['message' => 'Error message', 'parameter' => 'Error parameter'];
        $statusCode = 404;

        /** @var JsonResponse $result */
        $result = $this->apiControllerMock->successResponse($data, $statusCode);

        $this->assertInstanceOf(JsonResponse::class, $result);

        $object = new \stdClass();
        $object->message = 'Error message';
        $object->parameter = 'Error parameter';
        $this->assertEquals($result->getData(), $object);
        $this->assertEquals($result->getStatusCode(), $statusCode);
    }
}
