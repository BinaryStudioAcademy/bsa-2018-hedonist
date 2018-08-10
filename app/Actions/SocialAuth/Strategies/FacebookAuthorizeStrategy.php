<?php

namespace Hedonist\Actions\SocialAuth\Strategies;

use Hedonist\Entities\User\User as UserModel;
use Hedonist\Entities\User\UserInfo;
use Laravel\Socialite\Contracts\User as SocialUser;

class FacebookAuthorizeStrategy extends AbstractAuthorizeStrategy
{
    protected function createUserFromSocialData(SocialUser $user): UserModel
    {
        $appUser = new UserModel([
            'email' => $user->getEmail()
        ]);
        $userInfo = new UserInfo([
            'first_name' => $user->user['first_name'],
            'last_name' => $user->user['last_name'],
            'avatar_url' => $user->getAvatar()
        ]);
        $this->infoRepository->save($userInfo);

        return $this->userRepository->save($appUser);
    }
}