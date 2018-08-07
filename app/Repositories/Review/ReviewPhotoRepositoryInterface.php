<?php

namespace Hedonist\Repositories\Review;

use Hedonist\Entities\Review\ReviewPhoto;
use Illuminate\Database\Eloquent\Collection;
use Prettus\Repository\Contracts\CriteriaInterface;

interface ReviewPhotoRepositoryInterface
{
    public function save(ReviewPhoto $reviewPhoto): ReviewPhoto;

    public function getById(int $id) : ?ReviewPhoto;

    public function findAll(): Collection;

    public function findByCriteria(CriteriaInterface $criteria): Collection;

    public function deleteById(int $id): void;
}