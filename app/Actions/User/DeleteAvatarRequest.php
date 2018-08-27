<?php

namespace Hedonist\Actions\User;

class DeleteAvatarRequest
{
    private $userId;

    public function __construct(int $userId)
    {
        $this->userId = $userId;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }
}