<?php

declare(strict_types=1);

namespace Hedonist\Actions\Auth;

final class DeleteUserRequest
{
    private $userId;

    public function __construct(string $userId)
    {
        $this->userId = $userId;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }
}
