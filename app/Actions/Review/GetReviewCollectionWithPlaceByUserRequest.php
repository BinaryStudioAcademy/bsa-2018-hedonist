<?php

namespace Hedonist\Actions\Review;

class GetReviewCollectionWithPlaceByUserRequest
{
    private $userId;
    private $page;
    private $include;

    public function __construct(int $userId, int $page = 1, ?string $include)
    {
        $this->userId = $userId;
        $this->page = $page;
        $this->include = $include;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function getInclude(): ?string
    {
        return $this->include;
    }
}