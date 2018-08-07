<?php

namespace Hedonist\Actions\Place\Rate;


class GetPlaceRatingRequest
{
    /** @var int */
    protected $id;

    /** @var int */
    protected $userId;

    /** @var int */
    protected $placeId;


    /**
     * SetPlaceRatingResponse constructor.
     * @param int $id
     * @param int $userId
     * @param int $placeId
     */
    public function __construct($id = null, $userId = null, $placeId = null)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->placeId = $placeId;
    }

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getUserId(): ?int
    {
        return $this->userId;
    }

    /**
     * @return int
     */
    public function getPlaceId(): ?int
    {
        return $this->placeId;
    }

}