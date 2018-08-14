<?php

namespace Hedonist\Http\Middleware;

use Closure;
use Hedonist\Actions\Auth\Presenters\AuthPresenter;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Http\Middleware\Authenticate;
use Tymon\JWTAuth\JWTAuth;

class JwtAuthenticate extends Authenticate
{
    public function handle($request, Closure $next)
    {
        try {
            $this->authenticate($request);
        } catch (UnauthorizedHttpException $exception) {
            if ($exception->getPrevious() instanceof TokenExpiredException) {
                return $this->tokenExpireResponse(AuthPresenter::presentError($exception));
            }

            return $this->errorResponse(
                AuthPresenter::presentError($exception),
                401
            );
        }
        return $next($request);
    }

    protected function tokenExpireResponse(string $data, int $statusCode = 401) : JsonResponse
    {
        $errorData = [
            'error' => [
                'status' => $statusCode,
                'code' => 'token_expired',
                'message' => $data
            ]
        ];
        return JsonResponse::create($errorData, $statusCode);
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