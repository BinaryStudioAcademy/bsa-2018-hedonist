<?php

namespace Hedonist\Repositories\Dislike;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use Hedonist\Entities\Review\Review;

class ByReviewsAndUserCriteria implements CriteriaInterface
{
    private $reviewIds;
    private $userId;

    public function __construct(array $reviewIds, int $userId)
    {
        $this->reviewIds = $reviewIds;
        $this->userId = $userId;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        return $model
            ->whereIn('dislikeable_id', $this->reviewIds)
            ->where('dislikeable_type', '=', Review::class)
            ->where('user_id', '=', $this->userId);
    }
}