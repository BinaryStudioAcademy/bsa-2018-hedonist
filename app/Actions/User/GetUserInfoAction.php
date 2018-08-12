<?php

namespace Hedonist\Actions\User;

use Hedonist\Entities\User\UserInfo;
use Hedonist\Repositories\User\UserInfoRepository;

class GetUserInfoAction
{
    private $userInfoRepository;

    public function __construct(UserInfoRepository $userInfoRepository)
    {
        $this->userInfoRepository = $userInfoRepository;
    }

    public function execute(GetUserInfoRequest $userInfoRequest): GetUserInfoResponse
    {
        $userInfo = $this->userInfoRepository->getByUserId($userInfoRequest->getUserId());
        if (! $userInfo) {
            $userInfo = new UserInfo;
        }

        return new GetUserInfoResponse($userInfo);
    }
}