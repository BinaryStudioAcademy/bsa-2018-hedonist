<?php

namespace Hedonist\Repositories\Place;

use Hedonist\Entities\Place\Location;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class PlaceSearchCriteria implements CriteriaInterface
{
    private $page;
    private $categoryId;
    private $center;

    const LIMIT = 30;

    public function __construct(int $page, ?int $categoryId, ?Location $center)
    {
        $this->page = $page;
        $this->categoryId = $categoryId;
        $this->center = $center;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        if (!empty($this->center)) {
            $model = $model->select('*', DB::raw(
                '( ? * acos( cos( radians(?) ) * cos( radians( latitude ) ) 
            * cos( radians( longitude ) - radians(?) ) + sin( radians(?) ) * sin(radians(latitude)) ) ) AS distance'))
                ->having('distance', '<=', Location::RADIUS)
                ->setBindings([Location::EARTH_RADIUS_IN_KM, $this->center->getLatitude(), $this->center->getLongitude(), $this->center->getLatitude()]);
        }
        if (!empty($this->categoryId)) {
            $model = $model->where('category_id', $this->categoryId);
        }

        return $model->offset(($this->page - 1) * self::LIMIT)->limit(self::LIMIT);
    }
}
