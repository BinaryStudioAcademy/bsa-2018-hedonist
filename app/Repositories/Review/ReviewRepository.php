<?php

namespace Hedonist\Repositories\Review;

use Hedonist\Entities\Review\Review;
use Illuminate\Database\Eloquent\Collection;
use Prettus\Repository\Eloquent\BaseRepository;

class ReviewRepository extends BaseRepository implements ReviewRepositoryInterface
{
    public function findAll(): Collection
    {
        return Review::all();
    }

    public function getById(int $id): ?Review
    {
        return Review::find($id);
    }

    public function save(Review $review): Review
    {
        $review->save();
        return $review;
    }

    public function deleteById(int $id): void
    {
        $this->delete($id);
    }

    public function model()
    {
        return Review::class;
    }
}
