<?php

namespace Hedonist\Actions\Place\GetPlaceCategoryByName;

class GetPlaceCategoryByNameRequest
{
    private $name;
    private $limit;

    public function __construct(?string $name = '', ?int $limit = 10)
    {
        $this->name = $name ? $name : '';
        $this->limit = $limit ? $limit : 10;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getLimit(): int
    {
        return $this->limit;
    }
}