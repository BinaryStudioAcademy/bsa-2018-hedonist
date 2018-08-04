<?php

namespace Hedonist\Actions\Place\SpecialFeature;

class DeleteSpecialFeatureResponse
{
    protected $id;
    protected $result;

    /**
     * CreateSpecialFeatureResponse constructor.
     * @param $id
     * @param $name
     */
    public function __construct($id, $result)
    {
        $this->id = $id;
        $this->result = $result;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getResult()
    {
        return $this->result;
    }

}