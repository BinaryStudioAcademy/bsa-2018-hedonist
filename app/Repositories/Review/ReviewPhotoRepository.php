<?php

namespace Hedonist\Repositories\Review;


use Hedonist\Entities\Review\ReviewPhoto;
use Illuminate\Database\Eloquent\Collection;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Eloquent\BaseRepository;

class ReviewPhotoRepository extends BaseRepository implements ReviewPhotoRepositoryInterface
{
    public function save(ReviewPhoto $reviewPhoto): ReviewPhoto
    {
        $reviewPhoto->save();
        return $reviewPhoto;
    }

    public function getById(int $id): ?ReviewPhoto
    {
        return ReviewPhoto::find($id);
    }

    public function findAll(): Collection
    {
        return ReviewPhoto::all();
    }

    public function findByCriteria(CriteriaInterface $criteria): Collection
    {
        return $this->getByCriteria($criteria);
    }

    public function deleteById(int $id): void
    {
        $this->delete($id);
    }

    public function model()
    {
        return ReviewPhoto::class;
    }
}