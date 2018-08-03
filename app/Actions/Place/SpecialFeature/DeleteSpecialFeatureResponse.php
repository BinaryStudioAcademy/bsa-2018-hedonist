<?php

namespace Hedonist\Actions\Place\SpecialFeature;

use Hedonist\Actions\ResponseInterface;

class DeleteSpecialFeatureResponse implements ResponseInterface
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