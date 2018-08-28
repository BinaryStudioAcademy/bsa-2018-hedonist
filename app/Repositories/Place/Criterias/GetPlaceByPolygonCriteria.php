<?php

namespace Hedonist\Repositories\Place\Criterias;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class GetPlaceByPolygonCriteria implements CriteriaInterface
{
    private $polygon;

    public function __construct(string $polygon)
    {
        $this->polygon = $polygon;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        return $model->whereRaw("ST_CONTAINS(ST_GEOMFROMTEXT('POLYGON(($this->polygon))'), POINT(`places`.`longitude`, `places`.`latitude`))");
    }
}