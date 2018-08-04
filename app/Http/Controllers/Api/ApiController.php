<?php

namespace Hedonist\Http\Controllers\Api;

use Hedonist\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

abstract class ApiController extends Controller
{
    protected function successResponse(array $data, int $statusCode = JsonResponse::HTTP_OK) : JsonResponse
    {
        return JsonResponse::create(['data' => $data], $statusCode);
    }

    protected function errorResponse(string $data, int $statusCode = JsonResponse::HTTP_BAD_REQUEST) : JsonResponse
    {
        $errorData = [
            'error' => [
                'httpStatus' => $statusCode,
                'message' => $data
            ]
        ];
        return JsonResponse::create($errorData, $statusCode);
    }
}
