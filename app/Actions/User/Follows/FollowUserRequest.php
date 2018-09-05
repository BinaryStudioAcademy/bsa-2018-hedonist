<?php

namespace Hedonist\Actions\User\Follows;

class FollowUserRequest
{
    private $followedId;

    public function __construct(int $followedId)
    {
        $this->followedId = $followedId;
    }

    public function getFollowedId(): int
    {
        return $this->followedId;
    }
}