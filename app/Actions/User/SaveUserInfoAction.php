<?php

namespace Hedonist\Actions\User;

use Hedonist\Entities\User\UserInfo;
use Hedonist\Exceptions\User\UserInfoNotValidSocialUrlException;
use Hedonist\Exceptions\User\UserInfoRequiredFieldsException;
use Hedonist\Repositories\User\UserInfoRepositoryInterface as UserInfoRepository;
use Hedonist\Services\FileNameGenerator;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class SaveUserInfoAction
{
    const FILE_STORAGE = 'upload/avatar/';

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
        $avatar = $userInfoRequest->getAvatar();
        $facebook_url = $userInfoRequest->getFacebookUrl();
        $instagram_url = $userInfoRequest->getInstagramUrl();
        $twitter_url = $userInfoRequest->getTwitterUrl();

        if ($userHasNotInfo) {
            if (empty($first_name)) {
                throw new UserInfoRequiredFieldsException('First name field cannot be empty');
            }
            if (empty($last_name)) {
                throw new UserInfoRequiredFieldsException('Last name field cannot be empty');
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
        if ($userHasNotInfo || !empty($facebook_url)) {
            if (
                !empty($facebook_url) &&
                stripos(parse_url($facebook_url, PHP_URL_HOST), 'facebook.com') === false
            ) {
                throw new UserInfoNotValidSocialUrlException('Invalid facebook url');
            }

            $userInfo->facebook_url = $facebook_url;
        }
        if ($userHasNotInfo || !empty($instagram_url)) {
            if (
                !empty($instagram_url) &&
                stripos(parse_url($instagram_url, PHP_URL_HOST), 'instagram.com') === false
            ) {
                throw new UserInfoNotValidSocialUrlException('Invalid instagram url');
            }
            $userInfo->instagram_url = $instagram_url;
        }
        if ($userHasNotInfo || !empty($twitter_url)) {
            if (
                !empty($twitter_url) &&
                stripos(parse_url($twitter_url, PHP_URL_HOST), 'twitter.com') === false
            ) {
                throw new UserInfoNotValidSocialUrlException('Invalid twitter url');
            }
            $userInfo->twitter_url = $twitter_url;
        }

        if ($userHasNotInfo || !empty($avatar)) {
            $userInfo->avatar_url = $this->storeAvatar($avatar);
        }

        $userInfo = $this->userInfoRepository->save($userInfo);

        return new SaveUserInfoResponse($userInfo);
    }

    private function storeAvatar(?UploadedFile $avatar): string
    {
        $avatarUrl = "";
        if ($avatar !== null) {
            $newFileName = (new FileNameGenerator($avatar))->generateFileName();
            Storage::disk()->putFileAs(self::FILE_STORAGE, $avatar, $newFileName, 'public');
            $avatarUrl = Storage::url('upload/avatar/' . $newFileName);
        }
        return $avatarUrl;
    }
}