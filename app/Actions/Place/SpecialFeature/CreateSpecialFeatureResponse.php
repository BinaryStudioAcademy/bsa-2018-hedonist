<?php

namespace Hedonist\Actions\Place\SpecialFeature;

use Hedonist\Actions\ResponseInterface;

class CreateSpecialFeatureResponse implements ResponseInterface
{
    protected $id;
    protected $name;

    /**
     * CreateSpecialFeatureResponse constructor.
     * @param $id
     * @param $name
     */
    public function __construct($id, $name)
    {
        $this->id = $id;
        $this->name = $name;
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
    public function getName()
    {
        return $this->name;
    }

}