<?php

namespace Hedonist\Actions\Auth\Presenters;



use Hedonist\Actions\ResponseInterface;
use Hedonist\Entities\User;

class AuthPresenter
{
    public static function presentError(\Exception $exception)
    {
        return ["message"=>$exception->getMessage()];
    }

    public static function presentLoginResponse(ResponseInterface $response)
    {
        return [
            'access_token' => $response->getToken(),
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ];
    }

    public static function presentRegisterResponse(ResponseInterface $response)
    {
        return ['success'=>$response->getSuccess()];
    }

    public static function presentUser(User $user)
    {
        return $user->toArray();
    }

    public static function presentRefreshResponse(ResponseInterface $response)
    {
        return [
            'access_token' => $response->getToken(),
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ];
    }
}