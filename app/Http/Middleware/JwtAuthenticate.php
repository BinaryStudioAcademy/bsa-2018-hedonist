<?php

namespace Hedonist\Http\Middleware;

use Closure;
use Hedonist\Actions\Auth\Presenters\AuthPresenter;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\JWTAuth;

class JwtAuthenticate
{
    private $auth;

    public function __construct(JWTAuth $auth)
    {
        $this->auth = $auth;
    }

    public function handle($request, Closure $next)
    {
        $this->auth->parser()->setRequest($request);

        try {
            if (! $this->auth->parser()->hasToken()) {
                throw new UnauthorizedHttpException('jwt-auth', 'Token not provided');
            }

            if (! $this->auth->parseToken()->authenticate()) {
                throw new UnauthorizedHttpException('jwt-auth', 'User not found');
            }
        } catch (TokenExpiredException $exception) {
            return $this->tokenExpireResponse(AuthPresenter::presentError($exception));
        } catch (UnauthorizedHttpException $exception) {
            return $this->errorResponse(AuthPresenter::presentError($exception));
        } catch (JWTException $exception) {
            return $this->errorResponse(AuthPresenter::presentError($exception));
        }
        return $next($request);
    }

    protected function tokenExpireResponse(string $data, int $statusCode = JsonResponse::HTTP_UNAUTHORIZED) : JsonResponse
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

    protected function errorResponse(string $data, int $statusCode = JsonResponse::HTTP_UNAUTHORIZED) : JsonResponse
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
