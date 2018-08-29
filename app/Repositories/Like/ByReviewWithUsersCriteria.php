<?php

namespace Hedonist\Repositories\Like;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use Hedonist\Entities\Review\Review;

class ByReviewWithUsersCriteria implements CriteriaInterface
{
    private $reviewId;

    public function __construct(int $reviewId)
    {
        $this->reviewId = $reviewId;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        return $model->where('likeable_id', $this->reviewId)
            ->where('likeable_type', '=', Review::class)
            ->with(
                'user',
                'user.info'
            );
    }
}
