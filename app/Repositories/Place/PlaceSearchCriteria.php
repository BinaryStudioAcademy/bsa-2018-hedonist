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
    private $radius;

    const EARTH_RADIUS_IN_KM = 6371;
    const LIMIT = 10;

    public function __construct(int $page, ?int $categoryId, ?Location $center, float $radius = 30)
    {
        $this->page = $page;
        $this->categoryId = $categoryId;
        $this->center = $center;
        $this->radius = $radius;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        if (!empty($this->center)) {
            $model = $model->select('*', DB::raw(
                '( ? * acos( cos( radians(?) ) * cos( radians( latitude ) ) 
            * cos( radians( longitude ) - radians(?) ) + sin( radians(?) ) * sin(radians(latitude)) ) ) AS distance'))
                ->having('distance', '<=', $this->radius)
                ->setBindings([self::EARTH_RADIUS_IN_KM, $this->center->getLatitude(), $this->center->getLongitude(), $this->center->getLatitude()]);
        }
        if (!empty($this->categoryId)) {
            $model = $model->where('category_id', $this->categoryId);
        }

        return $model->with(
            'category',
            'category.tags',
            'city',
            'localization',
            'localization.language',
            'likes',
            'dislikes',
            'ratings')
            ->offset(($this->page - 1) * self::LIMIT)
            ->limit(self::LIMIT);
    }
}