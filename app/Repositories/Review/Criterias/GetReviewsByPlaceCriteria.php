<?php

namespace Hedonist\Repositories\Review\Criterias;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class GetReviewsByPlaceCriteria implements CriteriaInterface
{
    private $placeId;

    public function __construct(int $placeId)
    {
        $this->placeId = $placeId;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        return $model->where('place_id', $this->placeId);
    }
}