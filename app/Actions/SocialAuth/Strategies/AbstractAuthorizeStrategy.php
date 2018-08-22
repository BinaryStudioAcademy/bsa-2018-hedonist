<?php

namespace Hedonist\Actions\SocialAuth\Strategies;

use Hedonist\Entities\User\SocialAccount;
use Hedonist\Entities\User\UserInfo;
use Hedonist\Events\Auth\SocialRegistrationEvent;
use Hedonist\Repositories\User\SocialAccountRepositoryInterface;
use Hedonist\Repositories\User\UserInfoRepositoryInterface;
use Hedonist\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Laravel\Socialite\Contracts\User as SocialUser;
use Hedonist\Entities\User\User as UserModel;

abstract class AbstractAuthorizeStrategy implements SocialAuthorizeStrategyInterface
{
    protected static $provider = 'unknown';
    protected $userRepository;
    protected $infoRepository;
    protected $socialRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        UserInfoRepositoryInterface $infoRepository,
        SocialAccountRepositoryInterface $socialRepository
    )
    {
        $this->userRepository = $userRepository;
        $this->infoRepository = $infoRepository;
        $this->socialRepository = $socialRepository;
    }

    public function authorize(SocialUser $user): string
    {
        $appUser = $this->findOrCreate($user);

        return Auth::login($appUser);
    }

    protected function findOrCreate(SocialUser $socialUser): UserModel
    {
        $user = $this->userRepository->getUserBySocialAuthCredentials(
            static::$provider,
            $socialUser->getId()
        );
        if ($user !== null) { //all good, user with such social data is registered
            return $user;
        }

        return $this->createSocialAccount($socialUser);
    }

    protected function createSocialAccount(SocialUser $user): UserModel
    {
        $appUser = $this->userRepository->getByEmail($user->getEmail());
        if ($appUser !== null) { //user with such email exists,just create new social account and return user
            $this->createSocialData($appUser, $user);
        } else { //user record doesn't exists in our DB. Create a new one and attach social account to it.
            $appUser = $this->createUserFromSocialData($user);
            $this->createSocialData($appUser, $user);
        }

        return $appUser;
    }

    protected function createSocialData(UserModel $appUser, SocialUser $user)
    {
        $socialAccount = new SocialAccount([
            'provider' => static::$provider,
            'provider_user_id' => $user->getId(),
            'user_id' => $appUser->id,
        ]);
        $this->socialRepository->save($socialAccount);
    }

    abstract protected function createUserFromSocialData(SocialUser $user): UserModel;

    protected function notifyUser(UserModel $user, UserInfo $info, string $password)
    {
        Event::dispatch(new SocialRegistrationEvent($user, $info, $password));
    }
}