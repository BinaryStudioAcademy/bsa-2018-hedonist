<?php

namespace Hedonist\Actions\Review\GetLikedDislikedByUserReviews;

class GetLikedDislikedByUserReviewsResponse
{
    private $likedReviewsIds;
    private $dislikedReviewsIds;

    public function __construct(array $likedReviewsIds, array $dislikedReviewsIds)
    {
        $this->likedReviewsIds = $likedReviewsIds;
        $this->dislikedReviewsIds = $dislikedReviewsIds;
    }

    public function getLikedReviewsIds(): array
    {
        return $this->likedReviewsIds;
    }

    public function getDislikedReviewsIds(): array
    {
        return $this->dislikedReviewsIds;
    }
}