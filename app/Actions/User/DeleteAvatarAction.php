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

    public function execute(DeleteAvatarRequest $request): DeleteAvatarResponse
    {
        $userInfo = $this->userInfoRepository->getByUserId($request->getUserId());
        if (!$userInfo) {
            throw UserNotFoundException::create();
        }
        $filePath = str_replace('/storage/', '', $userInfo->avatar_url);
        Storage::disk('public')->delete($filePath);
        $userInfo->avatar_url = '';
        $userInfo = $this->userInfoRepository->save($userInfo);

        return new DeleteAvatarResponse($userInfo);
    }
}