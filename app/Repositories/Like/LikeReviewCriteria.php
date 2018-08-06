<?php

namespace Hedonist\Repositories\Like;

use Hedonist\Repository\Like\LikeRepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;
use Hedonist\Entities\Review\Review;

class LikeReviewCriteria implements CriteriaInterface 
{
    private $review_id;
    private $user_id;

    public function __construct(int $review_id, int $user_id)
    {
        $this->review_id = $review_id;
        $this->user_id = $user_id;
    } 

    public function apply($model, LikeRepositoryInterface $repository)
    {
        $model = $model->where('user_id', '=', $this->user_id)
            ->where('likeable_type', '=', Review::class)
            ->where('likeable_id', '=', $this->review_id);
        return $model;
    }
}