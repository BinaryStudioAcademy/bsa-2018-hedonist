<?php

namespace Hedonist\Actions\Place\GetPlaceCollectionByFilters;

class GetPlaceCollectionByFiltersRequest
{
    private $category_id;
    private $location;
    private $page;
    private $polygon;
    const DEFAULT_PAGE = 1;

    public function __construct(
        ?int $page,
        ?int $category_id,
        ?string $location,
        ?string $polygon
    ) {
        $this->location = $location;
        $this->category_id = $category_id;
        $this->page = $page;
        $this->polygon = $polygon;
    }

    public function getCategoryId(): ?int
    {
        return $this->category_id;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function getPage(): ?int
    {
        return $this->page;
    }

    public function getPolygon(): ?string
    {
        return $this->polygon;
    }
}
