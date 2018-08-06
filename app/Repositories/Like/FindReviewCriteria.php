<?php

namespace Hedonist\Repositories\Like;

use Hedonist\Repository\Like\LikeRepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;
use Hedonist\Entities\Review\Review;

class FindReviewCriteria implements CriteriaInterface 
{

    public function apply($model, $review_id, LikeRepositoryInterface $repository)
    {
        $model = $model->where('user_id', '=', Auth::user()->id)
            ->where('likeable_type', '=', Review::class)
            ->where('likeable_id', '=', $review_id);
        return $model;
    }
}