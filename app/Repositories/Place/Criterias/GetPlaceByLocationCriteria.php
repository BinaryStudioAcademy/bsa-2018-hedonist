<?php

namespace Hedonist\Repositories\Place\Criterias;

use Hedonist\Entities\Place\Location;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class GetPlaceByLocationCriteria implements CriteriaInterface
{
    private $center;

    public function __construct(Location $center)
    {
        $this->center = $center;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        return $model->select('*', DB::raw(
            '( ? * acos( cos( radians(?) ) * cos( radians( latitude ) ) 
            * cos( radians( longitude ) - radians(?) ) + sin( radians(?) ) * sin(radians(latitude)) ) ) AS distance'))
            ->having('distance', '<=', $this->center->getGeolocationRadius())
            ->setBindings([Location::EARTH_RADIUS_IN_KM, $this->center->getLatitude(), $this->center->getLongitude(), $this->center->getLatitude()]);
    }
}