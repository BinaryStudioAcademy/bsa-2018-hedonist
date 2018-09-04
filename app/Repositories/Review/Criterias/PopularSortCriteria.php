<?php

namespace Hedonist\Repositories\Review\Criterias;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class PopularSortCriteria implements CriteriaInterface
{
    const POPULAR_SORT = 'likes_count';
    const POPULAR_ORDER = 'desc';

    public function apply($model, RepositoryInterface $repository)
    {
        return $model->withCount(['likes'])->orderBy(self::POPULAR_SORT, self::POPULAR_ORDER);
    }
}