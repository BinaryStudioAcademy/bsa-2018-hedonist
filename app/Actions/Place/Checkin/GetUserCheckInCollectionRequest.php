<?php

namespace Hedonist\Actions\Place\Checkin;

class GetUserCheckInCollectionRequest
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