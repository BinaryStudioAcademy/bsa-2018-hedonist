<?php

namespace Hedonist\Repositories\Like;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use Hedonist\Entities\Review\Review;

class LikeReviewCriteria implements CriteriaInterface
{
    private $reviewId;
    private $userId;

    public function __construct(int $reviewId, int $userId)
    {
        $this->reviewId = $reviewId;
        $this->userId = $userId;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        return $model->where('user_id', '=', $this->userId)
            ->where('likeable_type', '=', Review::class)
            ->where('likeable_id', '=', $this->reviewId);
    }
}