<?php

namespace Hedonist\Actions\Presenters\Category\Tag;

use Hedonist\Actions\Presenters\PresentsCollection;
use Hedonist\Entities\Place\Tag;

class CategoryTagPresenter
{
    use PresentsCollection;

    public function present(Tag $tag): array
    {
        return [
            'id' => $tag->id,
            'name' => $tag->name
        ];
    }
}