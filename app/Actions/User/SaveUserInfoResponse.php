<?php

namespace Hedonist\Actions\User;

use Hedonist\Entities\User\UserInfo;

class SaveUserInfoResponse
{
    private $userId;
    private $firstName;
    private $lastName;
    private $dateOfBirth;
    private $phoneNumber;
    private $avatarUrl;
    private $facebookUrl;
    private $instagramUrl;
    private $twitterUrl;
    private $notificationsReceive;

    public function __construct(UserInfo $userInfo)
    {
        $this->userId = $userInfo->user_id;
        $this->firstName = $userInfo->first_name;
        $this->lastName = $userInfo->last_name;
        $this->dateOfBirth = $userInfo->date_of_birth;
        $this->phoneNumber = $userInfo->phone_number;
        $this->avatarUrl = $userInfo->avatar_url;
        $this->facebookUrl = $userInfo->facebook_url;
        $this->instagramUrl = $userInfo->instagram_url;
        $this->twitterUrl = $userInfo->twitter_url;
        $this->notificationsReceive = $userInfo->notifications_receive;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }


    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getDateOfBirth(): ?\DateTime
    {
        return $this->dateOfBirth;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function getAvatarUrl(): ?string
    {
        return $this->avatarUrl;
    }

    public function getFacebookUrl(): ?string
    {
        return $this->facebookUrl;
    }

    public function getInstagramUrl(): ?string
    {
        return $this->instagramUrl;
    }

    public function getTwitterUrl(): ?string
    {
        return $this->twitterUrl;
    }

    public function isNotificationsReceive(): bool
    {
        return $this->notificationsReceive;
    }
}