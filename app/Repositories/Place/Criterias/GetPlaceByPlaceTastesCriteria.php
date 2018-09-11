<?php

namespace Hedonist\Repositories\Place\Criterias;

use Illuminate\Database\Eloquent\Collection;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use Illuminate\Database\Eloquent\Builder;

class GetPlaceByPlaceTastesCriteria implements CriteriaInterface
{
    private $tastes;

    public function __construct(Collection $tastes)
    {
        $this->tastes = $tastes;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        $tasteIds = $this->tastes->pluck('id')->toArray();
        if (!empty($tasteIds)) {
            $model = $model->whereHas('tastes', function (Builder $query) use ($tasteIds) {
                $query->whereIn('place_tastes.taste_id', $tasteIds);
            });
        }

        return $model;
    }
}