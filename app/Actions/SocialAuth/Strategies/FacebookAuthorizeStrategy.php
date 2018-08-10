<?php

namespace Hedonist\Actions\SocialAuth\Strategies;

use Hedonist\Entities\User\User as UserModel;
use Laravel\Socialite\Contracts\User as SocialUser;

class FacebookAuthorizeStrategy extends AbstractAuthorizeStrategy
{
    protected function createUserFromSocialData(SocialUser $user): UserModel
    {
        // TODO: Implement createUserFromSocialData() method.
    }
}