<?php

namespace Hedonist\Actions\SocialAuth\Strategies;

use Laravel\Socialite\Contracts\User;

interface SocialAuthorizeStrategyInterface
{
    public function authorize(User $user):string;
}