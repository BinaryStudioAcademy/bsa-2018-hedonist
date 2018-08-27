<?php

namespace Hedonist\Actions\User;

use Hedonist\Exceptions\User\UserNotFoundException;
use Hedonist\Repositories\User\UserInfoRepository;
use Illuminate\Support\Facades\Storage;

class DeleteAvatarAction
{
    private $userInfoRepository;

    public function __construct(UserInfoRepository $userInfoRepository)
    {
        $this->userInfoRepository = $userInfoRepository;
    }

    public function execute(DeleteAvatarRequest $request): void
    {
        $userInfo = $this->userInfoRepository->getByUserId($request->getUserId());
        if (!$userInfo) {
            throw UserNotFoundException::create();
        }
        // TODO to fix the deletion of files by url
        $userInfo->avatar_url = '';
        $this->userInfoRepository->save($userInfo);
    }
}