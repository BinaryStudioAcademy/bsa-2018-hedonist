<?php

namespace Hedonist\Actions\Place\Checkin;

class SetCheckinRequest
{
    protected $userId;
    protected $placeId;

    public function __construct(int $placeId, int $userId = null)
    {
        $this->userId = $userId;
        $this->placeId = $placeId;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function getPlaceId(): int
    {
        return $this->placeId;
    }
}