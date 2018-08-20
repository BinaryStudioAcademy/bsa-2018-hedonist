<?php

namespace Hedonist\Actions\Presenters\Category;

use Hedonist\Entities\Place\PlaceCategory;

class CategoryPresenter
{
    public function present(PlaceCategory $category):array
    {
        return [
            'id' => $category->id,
            'name' => $category->name,
        ];
    }
}