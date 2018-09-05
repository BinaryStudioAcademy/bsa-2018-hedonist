<?php

namespace Hedonist\Actions\User;

use Hedonist\Entities\User\UserInfo;
use Hedonist\Repositories\User\Criterias\GetUsersByIdCriteria;
use Hedonist\Repositories\User\Criterias\WithFollowedAndFollowersCriteria;
use Hedonist\Repositories\User\UserRepositoryInterface;


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
        );
        return new GetUserInfoResponse($userInfo->first());
    }
}