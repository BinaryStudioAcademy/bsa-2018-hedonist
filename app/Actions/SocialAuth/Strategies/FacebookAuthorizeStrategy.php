<?php

namespace Hedonist\Actions\SocialAuth\Strategies;

use Hedonist\Entities\User\User as UserModel;
use Hedonist\Entities\User\UserInfo;
use Hedonist\Events\Auth\SocialRegistrationEvent;
use Illuminate\Support\Facades\Event;
use Laravel\Socialite\Contracts\User as SocialUser;

class FacebookAuthorizeStrategy extends AbstractAuthorizeStrategy
{
    protected function createUserFromSocialData(SocialUser $user): UserModel
    {
        $appUser = new UserModel([
            'email' => $user->getEmail()
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

        return $this->userRepository->save($appUser);
    }

    private function notifyUser(UserModel $user, UserInfo $info, string $password)
    {
        Event::dispatch(new SocialRegistrationEvent($user, $info, $password));
    }
}