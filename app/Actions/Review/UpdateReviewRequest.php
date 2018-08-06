<?php

namespace Hedonist\Actions\Review;

class UpdateReviewRequest
{
    private $userId;
    private $placeId;
    private $description;

    public function __construct(int $userId, int $placeId, string $description)
    {
        $this->userId = $userId;
        $this->placeId = $placeId;
        $this->description = $description;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getPlaceId(): int
    {
        return $this->placeId;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}
