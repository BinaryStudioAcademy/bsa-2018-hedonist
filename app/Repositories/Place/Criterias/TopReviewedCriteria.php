<?php

namespace Hedonist\Repositories\Place\Criterias;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class TopReviewedCriteria implements CriteriaInterface
{
    const TOP_REVIEW_COUNT = 10;

    public function apply($model, RepositoryInterface $repository)
    {
        return $model->has('reviews', '>=', self::TOP_REVIEW_COUNT);
    }
}