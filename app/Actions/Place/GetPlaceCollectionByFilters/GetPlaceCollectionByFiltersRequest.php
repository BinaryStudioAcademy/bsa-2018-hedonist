<?php

namespace Hedonist\Actions\Place\GetPlaceCollectionByFilters;

use Hedonist\Entities\Place\Location;

class GetPlaceCollectionByFiltersRequest
{
    private $category_id;
    private $location;
    private $page;

    public function __construct(int $page, ?int $category_id, ?string $location)
    {
        $this->location = Location::fromString($location);
        $this->category_id = $category_id;
        $this->page = $page;
    }

    public function getCategoryId(): ?int
    {
        return $this->category_id;
    }

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function getPage(): int
    {
        return $this->page;
    }
}