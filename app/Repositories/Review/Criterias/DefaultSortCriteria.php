<?php

namespace Hedonist\Repositories\Review\Criterias;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class DefaultSortCriteria implements CriteriaInterface
{
    const DEFAULT_SORT = 'created_at';
    const DEFAULT_ORDER = 'desc';

    public function apply($model, RepositoryInterface $repository)
    {
        return $model->orderBy(self::DEFAULT_SORT, self::DEFAULT_ORDER);
    }
}