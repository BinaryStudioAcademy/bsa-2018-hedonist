<?php

namespace Hedonist\Actions\User;

use Carbon\Carbon;

class SaveUserInfoRequest
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

    public function __construct(
        int $userId,
        $firstName,
        $lastName,
        $dateOfBirth = null,
        $phoneNumber = "",
        $avatarUrl = "",
        $facebookUrl = "",
        $instagramUrl = "",
        $twitterUrl = ""
    ) {
        $this->userId = $userId;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->dateOfBirth = $dateOfBirth;
        $this->phoneNumber = $phoneNumber;
        $this->avatarUrl = $avatarUrl;
        $this->facebookUrl = $facebookUrl;
        $this->instagramUrl = $instagramUrl;
        $this->twitterUrl = $twitterUrl;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }


    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function getDateOfBirth(): ?Carbon
    {
        if ($this->dateOfBirth !== null) {
            return Carbon::createFromFormat('Y/m/d', $this->dateOfBirth);
        }
        return null;
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
}