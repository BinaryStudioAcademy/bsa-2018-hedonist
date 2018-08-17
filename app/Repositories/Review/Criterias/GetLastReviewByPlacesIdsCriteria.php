<?php

namespace Hedonist\Repositories\Review\Criterias;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class GetLastReviewByPlacesIdsCriteria implements CriteriaInterface
{
    private $places;

    public function __construct(array $places)
    {
        $this->places = $places;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        return $model->whereIn('place_id', $this->places)
            ->distinct('place_id')
            ->orderByDesc('created_at');
    }
}