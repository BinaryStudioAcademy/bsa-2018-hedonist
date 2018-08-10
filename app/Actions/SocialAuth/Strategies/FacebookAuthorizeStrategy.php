<?php

namespace Hedonist\Actions\SocialAuth\Strategies;

use Hedonist\Repositories\User\UserInfoRepositoryInterface;
use Hedonist\Repositories\User\UserRepositoryInterface;
use Laravel\Socialite\Contracts\User as SocialUser;
use Hedonist\Entities\User\User as UserModel;

class FacebookAuthorizeStrategy implements SocialAuthorizeStrategyInterface
{
    private $userRepository;
    private $infoRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        UserInfoRepositoryInterface $infoRepository
    )
    {
        $this->userRepository = $userRepository;
        $this->infoRepository = $infoRepository;
    }

    public function authorize(SocialUser $user): string
    {

    }

    private function findOrCreate(SocialUser $socialUser): UserModel
    {

    }
}