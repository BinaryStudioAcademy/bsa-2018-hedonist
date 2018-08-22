<?php

namespace Hedonist\Actions\Place\SetPlaceRating;

class SetPlaceRatingResponse
{
    private $id;

    private $userId;

    private $placeId;

    private $ratingValue;

    public function __construct(int $id, int $userId, int $placeId, int $ratingValue)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->placeId = $placeId;
        $this->ratingValue = $ratingValue;
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
}