<?php

namespace Hedonist\Actions\Place\RemovePlaceCategory;

class RemovePlaceCategoryRequest
{
    private $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }
}