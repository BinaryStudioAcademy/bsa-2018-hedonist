<?php

namespace Hedonist\Repositories\Place;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class PlaceCategoryTagCriteria implements CriteriaInterface
{
    private $categoryId;

    public function __construct(int $id)
    {
        $this->categoryId = $id;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        return $model
            ->join('place_category_place_tag', 'place_categories_tags.id', 'place_category_place_tag.place_tag_id')
            ->where('place_category_place_tag.place_category_id', $this->categoryId);
    }
}