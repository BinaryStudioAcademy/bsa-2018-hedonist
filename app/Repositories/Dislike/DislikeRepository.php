<?php

namespace Hedonist\Repositories\Dislike;

use Hedonist\Entities\Dislike\Dislike;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Contracts\CriteriaInterface;
use Illuminate\Database\Eloquent\Collection;

class DislikeRepository extends BaseRepository implements DislikeRepositoryInterface
{
    public function model()
    {
        return Dislike::class;
    }

    public function save(Dislike $dislike): Dislike
    {
        $dislike->save();

        return $dislike;
    }

    public function getById(int $id): ?Dislike
    {
        return Dislike::find($id);
    }

    public function findAll(): Collection
    {
        return Dislike::all();
    }

    public function findByCriteria(CriteriaInterface $criteria): Collection
    {
        return $this->getByCriteria($criteria);
    }

    public function findByUserAndPlace(int $userId, int $placeId): ?Dislike
    {
        return Dislike::where([
            ['dislikeable_id', $placeId],
            ['dislikeable_type', 'places'],
            ['user_id', $userId]
        ])->first();
    }

    public function deleteById(int $id): void
    {
        Dislike::destroy($id);
    }
}