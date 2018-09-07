<?php

namespace Hedonist\Repositories\Review;

use Hedonist\Entities\Review\Review;
use Illuminate\Support\Collection;

class ElasticReviewRepository implements ElasticReviewRepositoryInterface
{
    public function findAll(): Collection
    {
        Review::search()->get();
    }

    public function getById(int $id): ?Review
    {
        return Review::search()->filter()->term('id', $id)->get()->first();
    }

    public function save(Review $review): Review
    {
        $review->save();

        return $review;
    }

    public function deleteById(int $id): void
    {
        $review = $this->getById($id);
        if(!is_null($review)){
            $review->delete();
        }
    }

    public function getTotalCountByPlace(int $placeId): int
    {
        return 0;
    }
}