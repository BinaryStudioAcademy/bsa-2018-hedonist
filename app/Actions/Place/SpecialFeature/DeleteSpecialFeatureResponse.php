<?php

namespace Hedonist\Actions\Place\SpecialFeature;

class DeleteSpecialFeatureResponse
{
    protected $id;

    /**
     * CreateSpecialFeatureResponse constructor.
     * @param $id
     * @param $name
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
}