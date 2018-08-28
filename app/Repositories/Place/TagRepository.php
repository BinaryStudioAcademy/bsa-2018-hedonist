<?php

namespace Hedonist\Repositories\Place;

use Illuminate\Database\Eloquent\Collection;
use Hedonist\Entities\Place\Tag;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Contracts\CriteriaInterface;

class TagRepository extends BaseRepository implements TagRepositoryInterface
{
    public function model()
    {
        return Tag::class;
    }
  
    public function save(Tag $tag): Tag
    {
        $tag->save();
        
        return $tag;
    }
    
    public function findAll(): Collection
    {
        return Tag::all();
    }
    
    public function getById(int $id): ?Tag
    {
        return Tag::find($id);
    }

    public function findByCategory(int $categoryId): Collection
    {
        return Tag::whereHas('categories', function ($query) use ($categoryId) {
            $query->where('place_category_id', $categoryId);
        })->get();
    }
    
    public function findByCriteria(CriteriaInterface $criteria): Collection
    {
        return $this->getByCriteria($criteria);
    }
    
    public function deleteById(int $id): void
    {
        Tag::destroy($id);
    }
}
