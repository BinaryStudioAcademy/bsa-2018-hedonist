<?php

namespace Hedonist\Http\Controllers;

use Illuminate\Http\JsonResponse;

abstract class ApiController extends Controller
{
    public function successResponse(array $data, int $statusCode = JsonResponse::HTTP_OK) : JsonResponse
    {
        return JsonResponse::create($data, $statusCode);
    }

    public function errorResponse(array $data, int $statusCode = JsonResponse::HTTP_BAD_REQUEST) : JsonResponse
    {
        return JsonResponse::create($data, $statusCode);
    }
}