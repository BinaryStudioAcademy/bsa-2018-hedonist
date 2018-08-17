<?php

namespace Hedonist\Actions\Presenters\Category\Tags;


use Hedonist\Entities\Place\PlaceCategoryTag;

class CategoryTagsPresenter
{
    public function present(PlaceCategoryTag $tag): array
    {
        return [
            'id' => $tag->id,
            'name' => $tag->name
        ];
    }
}