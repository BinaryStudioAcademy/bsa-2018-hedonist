<?php

namespace Hedonist\Repositories\Place\Criterias;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class LatestReviewForPlaceCriteria implements CriteriaInterface
{
    public function apply($model, RepositoryInterface $repository)
    {
        return $model->with(['reviews' => function (HasMany $builder) {
            $builder->orderByDesc('created_at')->distinct();
        }]);
    }
}