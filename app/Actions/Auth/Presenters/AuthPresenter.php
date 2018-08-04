<?php

namespace Hedonist\Actions\Auth\Presenters;

use Hedonist\Actions\Auth\Responses\AuthenticateResponseInterface;
use Hedonist\Actions\Auth\Responses\RegisterResponse;
use Hedonist\Entities\User;

class AuthPresenter
{
    public static function presentError(\Exception $exception)
    {
        return ["message" => $exception->getMessage()];
    }


    public static function presentAuthenticateResponse(AuthenticateResponseInterface $response)
    {
        return [
            'access_token' => $response->getToken(),
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ];
    }

    public static function presentRegisterResponse(RegisterResponse $response)
    {
        return ['success' => $response->getSuccess()];
    }

    public static function presentUser(User $user)
    {
        return $user->toArray();
    }
}