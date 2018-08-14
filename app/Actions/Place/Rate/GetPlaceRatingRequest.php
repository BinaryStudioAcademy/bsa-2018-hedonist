<?php

namespace Hedonist\Actions\Place\Rate;

class GetPlaceRatingRequest
{
    protected $id;

    protected $userId;

    protected $placeId;

    public function __construct(int $id = null, int $userId = null, int $placeId = null)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->placeId = $placeId;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function getPlaceId(): ?int
    {
        return $this->placeId;
    }
}