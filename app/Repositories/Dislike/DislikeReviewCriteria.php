<?php

namespace Hedonist\Repositories\Dislike;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use Hedonist\Entities\Review\Review;

class DislikeReviewCriteria implements CriteriaInterface
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
            ->where('dislikeable_type', '=', Review::class)
            ->where('dislikeable_id', '=', $this->reviewId);
    }
}