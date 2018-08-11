<?php

namespace Hedonist\Actions\Auth\Requests;

class ChangePasswordRequest
{
    private $oldPassword;
    private $newPassword;

    public function __construct(string $oldPassword, string $newPassword)
    {
        $this->oldPassword = $oldPassword;
        $this->newPassword = $newPassword;
    }

    public function getOldPassword(): string
    {
        return $this->oldPassword;
    }

    public function getNewPassword(): string
    {
        return $this->newPassword;
    }
}