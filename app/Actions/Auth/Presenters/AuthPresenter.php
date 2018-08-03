<?php

namespace Hedonist\Actions\Auth\Presenters;


use Hedonist\Actions\Auth\Responses\LoginResponseInterface;
use Hedonist\Actions\Auth\Responses\RegisterResponseInterface;

class AuthPresenter
{
    public static function presentError(\Exception $exception)
    {
        return ["message"=>$exception->getMessage()];
    }

    public static function presentLoginResponse(LoginResponseInterface $response)
    {
        return [
            'access_token' => $response->getToken(),
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ];
    }

    public static function presentRegisterResponse(RegisterResponseInterface $response)
    {
        return ['success'=>$response->getSuccess()];
    }
}