<?php

namespace Hedonist\Repositories\Place\Criterias;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class PlaceGetLastReviewByUserCriteria implements CriteriaInterface
{
    private $user;

    public function __construct(int $userId)
    {
        $this->user = $userId;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        return $model->with(['reviews' => function (HasMany $builder) {
            $builder->orderByDesc('created_at')
                ->where('user_id', $this->user)
                ->distinct();
        }]);
    }
}