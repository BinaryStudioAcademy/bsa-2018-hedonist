<?php

namespace Hedonist\Actions\User;

use Hedonist\Entities\User\User;
use Hedonist\Entities\User\UserInfo;
use Hedonist\Exceptions\Auth\PasswordsDosentMatchException;
use Hedonist\Exceptions\User\UserInfoNotValidSocialUrlException;
use Hedonist\Exceptions\User\UserInfoRequiredFieldsException;
use Hedonist\Repositories\User\UserInfoRepositoryInterface;
use Hedonist\Repositories\User\UserRepositoryInterface;
use Hedonist\Services\FileNameGenerator;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class SaveUserInfoAction
{
    const FILE_STORAGE = 'upload/avatar/';

    private $userInfoRepository;
    private $userRepository;

    public function __construct(
        UserInfoRepositoryInterface $userInfoRepository,
        UserRepositoryInterface $userRepository
    ) {
        $this->userInfoRepository = $userInfoRepository;
        $this->userRepository = $userRepository;
    }

    public function execute(SaveUserInfoRequest $userInfoRequest): SaveUserInfoResponse
    {
        if ($userInfoRequest->getOldPassword() && $userInfoRequest->getNewPassword()) {
            /** @var User $user */
            $user = Auth::user();
            $this->validatePassword($user, $userInfoRequest->getOldPassword());
            $user->password = Hash::make($userInfoRequest->getNewPassword());
            $this->userRepository->save($user);
        }

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

        if (!empty($first_name)) {
            $userInfo->first_name = $first_name;
        }

        if (!empty($last_name)) {
            $userInfo->last_name = $last_name;
        }

        $userInfo->date_of_birth = $date_of_birth;

        $userInfo->phone_number = $phone_number;

        if (!$this->validateSocialUrl($facebook_url, 'facebook.com')) {
            throw new UserInfoNotValidSocialUrlException('Invalid facebook url');
        }
        $userInfo->facebook_url = $facebook_url;

        if (!$this->validateSocialUrl($instagram_url, 'instagram.com')) {
            throw new UserInfoNotValidSocialUrlException('Invalid instagram url');
        }
        $userInfo->instagram_url = $instagram_url;

        if (!$this->validateSocialUrl($twitter_url, 'twitter.com')) {
            throw new UserInfoNotValidSocialUrlException('Invalid twitter url');
        }
        $userInfo->twitter_url = $twitter_url;

        if ($userHasNotInfo || !empty($avatar)) {
            $userInfo->avatar_url = $this->storeAvatar($avatar);
        }

        $userInfo = $this->userInfoRepository->save($userInfo);

        return new SaveUserInfoResponse($userInfo);
    }

    private function storeAvatar(UploadedFile $avatar): string
    {
        $newFileName = (new FileNameGenerator($avatar))->generateFileName();
        Storage::disk()->putFileAs(self::FILE_STORAGE, $avatar, $newFileName, 'public');
        return Storage::url(self::FILE_STORAGE . $newFileName);
    }

    private function validatePassword(User $user, string $oldPassword): void
    {
        if (!Hash::check($oldPassword, $user->getAuthPassword())) {
            throw new PasswordsDosentMatchException();
        }
    }

    private function validateSocialUrl(?string $socialUrl, string $baseUrlHostOfSocial): bool
    {
        return (
            empty($socialUrl) ||
            stripos(parse_url($socialUrl, PHP_URL_HOST), $baseUrlHostOfSocial) !== false
        );
    }
}