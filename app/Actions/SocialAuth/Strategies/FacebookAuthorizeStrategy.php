<?php

namespace Hedonist\Actions\SocialAuth\Strategies;

use Hedonist\Entities\User\User as UserModel;
use Hedonist\Entities\User\UserInfo;
use Laravel\Socialite\Contracts\User as SocialUser;

class FacebookAuthorizeStrategy extends AbstractAuthorizeStrategy
{
    protected function createUserFromSocialData(SocialUser $user): UserModel
    {
        $password = str_random(self::PASSWORD_LENGTH);
        $appUser = new UserModel([
            'email' => $user->getEmail(),
            'password' => $password
        ]);
        $appUser = $this->userRepository->save($appUser);
        $parsedName = explode(' ', $user->getName());
        $userInfo = new UserInfo([
            'user_id' => $appUser->id,
            'first_name' => $parsedName[0],
            'last_name' => $parsedName[1],
            'avatar_url' => $user->getAvatar()
        ]);
        $this->infoRepository->save($userInfo);
        $this->notifyUser($appUser, $userInfo, $password);

        return $this->userRepository->save($appUser);
    }
}