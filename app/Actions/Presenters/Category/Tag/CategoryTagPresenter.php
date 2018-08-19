<?php

namespace Hedonist\Actions\Presenters\Category\Tag;

use Hedonist\Actions\Presenters\PresentsCollection;
use Hedonist\Entities\Place\PlaceCategoryTag;

class CategoryTagPresenter
{
    use PresentsCollection;

    public function present(PlaceCategoryTag $tag): array
    {
        return [
            'id' => $tag->id,
            'name' => $tag->name
        ];
    }
}