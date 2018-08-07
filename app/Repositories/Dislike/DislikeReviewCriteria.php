<?php

namespace Hedonist\Repositories\Dislike;

use Hedonist\Repository\Dislike\DislikeRepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use Hedonist\Entities\Review\Review;

class DislikeReviewCriteria implements CriteriaInterface 
{
    private $review_id;
    private $user_id;

    public function __construct(int $review_id, int $user_id)
    {
        $this->review_id = $review_id;
        $this->user_id = $user_id;
    } 

    public function apply($model, RepositoryInterface $repository)
    {
        return $model->where('user_id', '=', $this->user_id)
            ->where('dislikeable_type', '=', Review::class)
            ->where('dislikeable_id', '=', $this->review_id);
    }
}