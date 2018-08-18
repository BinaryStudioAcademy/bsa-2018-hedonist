<?php

namespace Hedonist\Actions\Presenters\Category\Tag;

use Hedonist\Actions\Presenters\PresentsCollectionTrait;
use Hedonist\Entities\Place\PlaceCategoryTag;

class CategoryTagPresenter
{
    use PresentsCollectionTrait;

    public function present(PlaceCategoryTag $tag): array
    {
        return [
            'id' => $tag->id,
            'name' => $tag->name
        ];
    }
}