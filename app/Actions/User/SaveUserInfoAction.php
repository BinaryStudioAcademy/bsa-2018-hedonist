<?php

namespace Hedonist\Actions\User;

use Hedonist\Entities\User\UserInfo;
use Hedonist\Exceptions\UserInfoExceptions\UserInfoRequiredFieldsException;
use Hedonist\Repositories\User\UserInfoRepositoryInterface as UserInfoRepository;

class SaveUserInfoAction
{
    private $userInfoRepository;

    public function __construct(UserInfoRepository $userInfoRepository)
    {
        $this->userInfoRepository = $userInfoRepository;
    }

    public function execute(SaveUserInfoRequest $userInfoRequest): SaveUserInfoResponse
    {
        $userInfo = $this->userInfoRepository->getByUserId($userInfoRequest->getUserId());
        $userHasNotInfo = !$userInfo;
        if ($userHasNotInfo) {
            $userInfo = new UserInfo;
            $userInfo->user_id = $userInfoRequest->getUserId();
        }
        $first_name = $userInfoRequest->getFirstName();
        $last_name = $userInfoRequest->getLastName();
        $date_of_birth = $userInfoRequest->getDateOfBirth();
        $phone_number = $userInfoRequest->getPhoneNumber();
        $avatar_url = $userInfoRequest->getAvatarUrl();
        $facebook_url = $userInfoRequest->getFacebookUrl();
        $instagram_url = $userInfoRequest->getInstagramUrl();
        $twitter_url = $userInfoRequest->getTwitterUrl();

        if ($userHasNotInfo) {
            if (empty($first_name)) {
                throw(new UserInfoRequiredFieldsException('First name field cannot be empty'));
            }
            if (empty($last_name)) {
                throw(new UserInfoRequiredFieldsException('Last name field cannot be empty'));
            }
        }

        if ($userHasNotInfo || !empty($first_name)) {
            $userInfo->first_name = $first_name;
        }

        if ($userHasNotInfo || !empty($last_name)) {
            $userInfo->last_name = $last_name;
        }

        if ($userHasNotInfo || !empty($date_of_birth)) {
            $userInfo->date_of_birth = $date_of_birth;
        }
        if ($userHasNotInfo || !empty($phone_number)) {
            $userInfo->phone_number = $phone_number;
        }
        if ($userHasNotInfo || !empty($avatar_url)) {
            $userInfo->avatar_url = $avatar_url;
        }
        if ($userHasNotInfo || !empty($facebook_url)) {
            $userInfo->facebook_url = $facebook_url;
        }
        if ($userHasNotInfo || !empty($instagram_url)) {
            $userInfo->instagram_url = $instagram_url;
        }
        if ($userHasNotInfo || !empty($twitter_url)) {
            $userInfo->twitter_url = $twitter_url;
        }

        $userInfo = $this->userInfoRepository->save($userInfo);

        return new SaveUserInfoResponse($userInfo);
    }
}