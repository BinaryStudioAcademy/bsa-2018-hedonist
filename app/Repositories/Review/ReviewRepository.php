<?php

namespace Hedonist\Repositories\Review;

use Hedonist\Entities\Review\Review;
use Hedonist\Repositories\Review\Criterias\GetReviewsByPlaceCriteria;
use Illuminate\Database\Eloquent\Collection;
use Prettus\Repository\Contracts\CriteriaInterface;
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

    public function findByCriteria(CriteriaInterface $criteria): Collection
    {
        return $this->getByCriteria($criteria);
    }

    public function findCollectionByCriterias(CriteriaInterface ...$criterias): Collection
    {
        foreach ($criterias as $criteria) {
            $this->pushCriteria($criteria);
        }
        $result = $this->all();
        $this->resetCriteria();

        return $result;
    }

    public function setOrderBy(?string $column = 'id', ?string $direction = 'asc'): ReviewRepositoryInterface
    {
        return $this->orderBy($column, $direction);
    }

    public function getTotalCountByPlace(int $placeId): int
    {
        return Review::where('place_id', $placeId)->count();
    }

    public function getTotalCount(): int
    {
        return Review::count();
    }
}
