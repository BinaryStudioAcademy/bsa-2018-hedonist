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
        $this->location = $location;
        if (!empty($location) && preg_match('/^[0-9]+(\.[0-9]+)?,[0-9]+(\.[0-9]+)?$/', $location) == false) {
            throw new \InvalidArgumentException('The location has an incorrect format');
        } elseif (!empty($location) && preg_match('/^[0-9]+(\.[0-9]+)?,[0-9]+(\.[0-9]+)?$/', $location)) {
            $locationToArray = explode(',', $location);
            $longitude = $locationToArray[0];
            $latitude = $locationToArray[1];
            $this->location = new Location($longitude, $latitude);
        }

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