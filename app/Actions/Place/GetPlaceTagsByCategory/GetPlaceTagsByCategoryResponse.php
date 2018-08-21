<?php

namespace Hedonist\Actions\Place\GetPlaceTagsByCategory;

use Illuminate\Database\Eloquent\Collection;

class GetPlaceTagsByCategoryResponse
{
    private $categoryTags;

    public function __construct(Collection $tags)
    {
        $this->categoryTags = $tags;
    }

    public function getTags(): array
    {
        return $this->categoryTags->toArray();
    }
}