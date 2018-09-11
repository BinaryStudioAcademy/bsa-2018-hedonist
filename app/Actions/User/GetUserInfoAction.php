<?php

namespace Hedonist\Actions\User;

use Hedonist\Exceptions\User\UserNotFoundException;
use Hedonist\Repositories\User\Criterias\GetUsersByIdCriteria;
use Hedonist\Repositories\User\Criterias\WithFollowedAndFollowersCriteria;
use Hedonist\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class GetUserInfoAction
{
    private $userRepository;

    public function __construct(UserRepositoryInterface $userInfoRepository)
    {
        $this->userRepository = $userInfoRepository;
    }

    public function execute(GetUserInfoRequest $userInfoRequest): GetUserInfoResponse
    {
        $userInfo = $this->userRepository->findByCriterias(
            new GetUsersByIdCriteria($userInfoRequest->getUserId()),
            new WithFollowedAndFollowersCriteria()
        )->first();
        if (!$userInfo) {
            throw new UserNotFoundException();
        }

        return new GetUserInfoResponse($userInfo, Auth::user(), $userInfo->followers, $userInfo->followedUsers);
    }
}