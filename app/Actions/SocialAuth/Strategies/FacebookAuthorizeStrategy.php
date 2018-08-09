<?php

namespace Hedonist\Actions\SocialAuth\Strategies;

use Hedonist\Repositories\User\UserInfoRepositoryInterface;
use Hedonist\Repositories\User\UserRepositoryInterface;
use Laravel\Socialite\Contracts\User;

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

    public function authorize(User $user): string
    {

    }
}