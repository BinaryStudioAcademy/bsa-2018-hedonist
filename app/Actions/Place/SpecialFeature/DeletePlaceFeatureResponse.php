<?php

namespace Hedonist\Actions\Place\SpecialFeature;

class DeletePlaceFeatureResponse
{
    protected $id;
    protected $result;

    public function __construct(int $id, string $result)
    {
        $this->id = $id;
        $this->result = $result;
    }

    public function getId() : int
    {
        return $this->id;
    }

    public function getResult() : string
    {
        return $this->result;
    }
}