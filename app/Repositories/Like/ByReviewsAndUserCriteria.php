<?php

namespace Hedonist\Repositories\Like;

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
            ->whereIn('likeable_id', $this->reviewIds)
            ->where('likeable_type', '=', Review::class)
            ->where('user_id', '=', $this->userId);
    }
}