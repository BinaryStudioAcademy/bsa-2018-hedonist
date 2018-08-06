<?php

namespace Hedonist\Actions\Place\Rate;


class GetPlaceRatingResponse
{
    /** @var int */
    protected $id;

    /** @var int */
    protected $userId;

    /** @var int */
    protected $placeId;

    /** @var float */
    protected $ratingValue;

    /**
     * SetPlaceRatingResponse constructor.
     * @param int $id
     * @param int $userId
     * @param int $placeId
     * @param float $ratingValue
     */
    public function __construct($id, $userId, $placeId, $ratingValue)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->placeId = $placeId;
        $this->ratingValue = $ratingValue;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @return int
     */
    public function getPlaceId(): int
    {
        return $this->placeId;
    }

    /**
     * @return float
     */
    public function getRatingValue(): float
    {
        return $this->ratingValue;
    }

}