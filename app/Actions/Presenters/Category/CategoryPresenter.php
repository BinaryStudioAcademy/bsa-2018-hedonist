<?php

namespace Hedonist\Actions\Presenters\Category;

use Hedonist\Entities\Place\PlaceCategory;

class CategoryPresenter
{
    private $presentation = [];

    public function present(PlaceCategory $category):array
    {
        return array_merge(
            [
            'id' => $category->id,
            'name' => $category->name,
            ],
            $this->presentation
        );
    }

    public function withTags(PlaceCategory $category): self
    {
        $this->presentation['tags'] = [];
        foreach ($category->tags as $tag) {
            $this->presentation['tags'][] = [
                'id' => $tag->id,
                'name' => $tag->name
            ];
        }

        return $this;
    }
}