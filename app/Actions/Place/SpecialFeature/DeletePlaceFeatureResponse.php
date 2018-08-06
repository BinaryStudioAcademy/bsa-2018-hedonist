<?php

namespace Hedonist\Actions\Place\SpecialFeature;

class DeletePlaceFeatureResponse
{
    protected $id;
    protected $result;

    /**
     * CreatePlaceFeatureResponse constructor.
     * @param int $id
     * @param string $result
     */
    public function __construct(int $id, string $result)
    {
        $this->id = $id;
        $this->result = $result;
    }

    /**
     * @return int
     */
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getResult() : string
    {
        return $this->result;
    }

}