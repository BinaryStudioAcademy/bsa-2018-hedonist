<?php

namespace Hedonist\Actions\Place\GetPlaceCollectionByFilters;

class GetPlaceCollectionByFiltersRequest
{
    private $category_id;
    private $location;
    private $page;
    private $name;
    private $polygon;
    private $topReviewed;
    private $topRated;
    private $checkin;
    private $saved;
    private $opened;
  
    const DEFAULT_PAGE = 1;

    public function __construct(
        ?int $page,
        ?int $category_id,
        ?string $location,
        ?string $name,
        ?string $polygon,
        ?bool $topReviewed = false,
        ?bool $topRated = false,
        ?bool $checkin = false,
        ?bool $saved = false,
        ?bool $opened = false
    ) {
        $this->location = $location;
        $this->category_id = $category_id;
        $this->page = $page;
        $this->name = $name;
        $this->polygon = $polygon;
        $this->topReviewed = $topReviewed;
        $this->topRated = $topRated;
        $this->checkin = $checkin;
        $this->saved = $saved;
        $this->opened = $opened;
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

    public function isTopReviewed(): bool
    {
        return (bool) $this->topReviewed;
    }

    public function isTopRated(): bool
    {
        return (bool) $this->topRated;
    }

    public function isCheckin(): bool
    {
        return (bool) $this->checkin;
    }

    public function isSaved(): bool
    {
        return (bool) $this->saved;
    }

    public function isOpened(): bool
    {
        return (bool) $this->opened;
    }
  
    public function getPolygon(): ?string
    {
        return $this->polygon;
    }

    public function getName(): ?string
    {
        return $this->name;
    }
}
