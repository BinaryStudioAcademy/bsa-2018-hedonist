<?php

namespace Hedonist\Actions\SocialAuth\Strategies;

use Laravel\Socialite\Contracts\User;

interface SocialAuthorizeStrategyInterface
{
    const PASSWORD_LENGTH = 16;

    public function authorize(User $user):string;
}