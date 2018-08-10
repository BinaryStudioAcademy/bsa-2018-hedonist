<?php

namespace Hedonist\Http\Controllers\Api\Auth;


use Hedonist\Http\Controllers\Api\ApiController;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends ApiController
{
    public function redirect(string $provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback(string $provider)
    {

    }
}