<?php

namespace Hedonist\Repositories\Place\Criterias;

use Illuminate\Support\Facades\DB;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class TopRatedCriteria implements CriteriaInterface
{
    const TOP_RATING = 8;

    public function apply($model, RepositoryInterface $repository)
    {
        return $model->whereHas('ratings', function ($query) {
            $query->select('place_id', DB::raw('AVG(rating) as avg_rating'))
                ->groupBy('place_id')
                ->havingRaw('avg_rating >= ?', [self::TOP_RATING]);
        });
    }
}