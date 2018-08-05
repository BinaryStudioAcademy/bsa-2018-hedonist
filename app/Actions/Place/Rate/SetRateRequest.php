<?php

namespace Hedonist\Actions\Place\Rate;

class SetRateRequest
{
    /** @var int */
    protected $id;

    /** @var int */
    protected $userId;

    /** @var int */
    protected $placeId;

    /** @var float */
    protected $rateValue;

    /**
     * SetRateRequest constructor.
     * @param int $id
     * @param int $userId
     * @param int $placeId
     * @param float $rateValue
     */
    public function __construct($id = null, $userId = null, $placeId = null, $rateValue)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->placeId = $placeId;
        $this->rateValue = $rateValue;
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
    public function getRateValue(): float
    {
        return $this->rateValue;
    }



}