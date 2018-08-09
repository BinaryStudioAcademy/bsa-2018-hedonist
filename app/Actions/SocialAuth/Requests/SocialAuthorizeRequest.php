<?php

namespace Hedonist\Actions\SocialAuth\Requests;

use Laravel\Socialite\Contracts\User;

class SocialAuthorizeRequest
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getOauthUser():User
    {
        return $this->user;
    }
}