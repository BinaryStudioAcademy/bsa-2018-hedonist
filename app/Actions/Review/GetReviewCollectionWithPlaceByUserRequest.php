<?php

namespace Hedonist\Actions\Review;

class GetReviewCollectionWithPlaceByUserRequest
{
    private $userId;
    private $page;

    public function __construct(int $userId, int $page = 1)
    {
        $this->userId = $userId;
        $this->page = $page;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getPage(): int
    {
        return $this->page;
    }
}