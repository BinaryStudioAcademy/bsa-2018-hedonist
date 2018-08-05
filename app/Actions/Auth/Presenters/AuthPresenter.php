<?php

namespace Hedonist\Actions\Auth\Presenters;

use Hedonist\Actions\Auth\Responses\AuthenticateResponseInterface;
use Hedonist\Actions\Auth\Responses\RegisterResponse;
use Hedonist\Entities\User;

class AuthPresenter
{
    public static function presentError(\Exception $exception): string
    {
        return $exception->getMessage();
    }


    public static function presentAuthenticateResponse(AuthenticateResponseInterface $response): array
    {
        return [
            'access_token' => $response->getToken(),
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ];
    }

    public static function presentUser(User $user): array
    {
        return $user->toArray();
    }
}