<?php

namespace Hedonist\Repositories\Place\Criterias;

use Illuminate\Support\Facades\DB;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class TopRatedCriteria implements CriteriaInterface
{
    const TOP_RATING = 4;

    public function apply($model, RepositoryInterface $repository)
    {
        return $model->withCount(['ratings as average_rating' => function($query) {
            $query->select(DB::raw('coalesce(avg(rating),0)'));
        }])->having('average_rating', '>=', self::TOP_RATING)->orderBy('average_rating', 'desc');
    }
}