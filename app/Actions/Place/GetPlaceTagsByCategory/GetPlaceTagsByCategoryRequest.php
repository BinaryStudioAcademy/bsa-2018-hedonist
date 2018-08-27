<?php

namespace Hedonist\Actions\Place\GetPlaceTagsByCategory;

class GetPlaceTagsByCategoryRequest
{
    private $categoryId;

    public function __construct(int $id)
    {
        $this->categoryId = $id;
    }

    public function getCategoryId(): int
    {
        return $this->categoryId;
    }
}