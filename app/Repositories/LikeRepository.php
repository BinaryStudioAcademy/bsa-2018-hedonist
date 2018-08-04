<?php

namespace Hedonist\Repositories;

use Hedonist\Entities\Like;
use Illuminate\Database\Eloquent\Collection;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Eloquent\BaseRepository;

class LikeRepository extends BaseRepository implements LikeRepositoryInterface
{
    public function model()
    {
        return Like::class;
    }

    public function save(Like $like): Like
    {
        $like->save();

        return $like;
    }

    public function getById(int $id): ?Like
    {
        return Like::find($id);
    }

    public function findAll(): Collection
    {
        return Like::all();
    }

    public function findByCriteria(CriteriaInterface $criteria): Collection
    {
        return $this->getByCriteria($criteria);
    }

    public function deleteById(int $id): void
    {
        Like::destroy($id);
    }
}