<?php

namespace Hedonist\Repositories\Review;

use Hedonist\Entities\Review\Review;
use Illuminate\Database\Eloquent\Collection;

interface ReviewRepositoryInterface
{
    public function findAll(): Collection;

    public function getById(int $id): ?Review;

    public function save(Review $review): Review;

    public function deleteById(int $id): void;
}
