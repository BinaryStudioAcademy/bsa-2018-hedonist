<?php

namespace Hedonist\Actions\Place\Presenters\Review;

use Hedonist\Entities\Review\Review;

class ReviewPresenter
{
    public function present(Review $review, ?int $userId = null): array
    {
        return [
            'created_at' => $review->created_at,
            'description' => $review->description,
            'user' => $review->user->info,
            'likes' => $review->likes->count(),
            'dislikes' => $review->dislikes()->count(),
            'disliked' => $review->isDisliked($userId),
            'liked' => $review->isLiked($userId)
        ];
    }
}