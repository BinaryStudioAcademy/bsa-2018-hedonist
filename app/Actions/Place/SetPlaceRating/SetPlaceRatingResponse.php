<?php

namespace Hedonist\Actions\Place\SetPlaceRating;

class SetPlaceRatingResponse
{
    private $id;

    private $userId;

    private $placeId;

    private $ratingValue;

    private $ratingAvg;

    private $ratingCount;

    public function __construct(int $id, int $userId, int $placeId, int $ratingValue, float $ratingAvg, int $ratingCount)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->placeId = $placeId;
        $this->ratingValue = $ratingValue;
        $this->ratingAvg = $ratingAvg;
        $this->ratingCount = $ratingCount;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getPlaceId(): int
    {
        return $this->placeId;
    }

    public function getRatingValue(): int
    {
        return $this->ratingValue;
    }

    public function getRatingAvg(): float
    {
        return $this->ratingAvg;
    }

    public function getRatingCount(): int
    {
        return $this->ratingCount;
    }
}