<?php

namespace Hedonist\Actions\User;

use Carbon\Carbon;
use Illuminate\Http\UploadedFile;

class SaveUserInfoRequest
{
    private $userId;
    private $firstName;
    private $lastName;
    private $dateOfBirth;
    private $phoneNumber;
    private $avatar;
    private $facebookUrl;
    private $instagramUrl;
    private $twitterUrl;
    private $oldPassword;
    private $newPassword;
    private $isPrivate;

    public function __construct(
        int $userId,
        ?string $firstName,
        ?string $lastName,
        ?string $dateOfBirth = null,
        ?string $phoneNumber = "",
        ?UploadedFile $avatar = null,
        ?string $facebookUrl = "",
        ?string $instagramUrl = "",
        ?string $twitterUrl = "",
        ?string $oldPassword = null,
        ?string $newPassword = null,
        ?bool $isPrivate = null
    ) {
        $this->userId = $userId;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->dateOfBirth = $dateOfBirth;
        $this->phoneNumber = $phoneNumber;
        $this->facebookUrl = $facebookUrl;
        $this->instagramUrl = $instagramUrl;
        $this->twitterUrl = $twitterUrl;
        $this->avatar = $avatar;
        $this->oldPassword = $oldPassword;
        $this->newPassword = $newPassword;
        $this->isPrivate = $isPrivate;
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

    public function getAvatar(): ?UploadedFile
    {
        return $this->avatar;
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

    public function getOldPassword(): ?string
    {
        return $this->oldPassword;
    }

    public function getNewPassword(): ?string
    {
        return $this->newPassword;
    }

    public function getIsPrivate(): ?bool
    {
        return $this->isPrivate;
    }
}