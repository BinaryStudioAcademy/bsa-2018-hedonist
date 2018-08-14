<?php

namespace Hedonist\Actions\Place\GetPlaceItem;

use Hedonist\Entities\Place\City;
use Hedonist\Entities\Place\Place;
use Hedonist\Entities\Place\PlaceCategory;
use Illuminate\Database\Eloquent\Collection;

class GetPlaceItemResponse
{
    private $id;
    private $creator_id;
    private $category_id;
    private $city_id;
    private $longitude;
    private $latitude;
    private $zip;
    private $address;
    private $phone;
    private $website;
    private $createdAt;
    private $updatedAt;
    private $localization;
    private $category;
    private $city;
    private $rating;
    private $reviews;
    private $features;

    public function __construct(
        Place $place,
        PlaceCategory $placeCategory,
        City $city,
        ?float $rating,
        Collection $localization,
        Collection $reviews,
        Collection $features
    ) {
        $this->id           = $place->id;
        $this->creator_id   = $place->creator_id;
        $this->category_id  = $place->category_id;
        $this->city_id      = $place->city_id;
        $this->longitude    = $place->longitude;
        $this->latitude     = $place->latitude;
        $this->zip          = $place->zip;
        $this->address      = $place->address;
        $this->phone        = $place->phone;
        $this->website      = $place->website;
        $this->createdAt    = $place->created_at;
        $this->updatedAt    = $place->updated_at;
        $this->localization = $localization;
        $this->category     = $placeCategory;
        $this->city         = $city;
        $this->rating       = $rating;
        $this->reviews      = $reviews;
        $this->features     = $features;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCreatorId(): int
    {
        return $this->creator_id;
    }

    public function getCategoryId(): int
    {
        return $this->category_id;
    }

    public function getCityId(): int
    {
        return $this->city_id;
    }

    public function getLongitude(): float
    {
        return $this->longitude;
    }

    public function getLatitude(): float
    {
        return $this->latitude;
    }

    public function getZip(): int
    {
        return $this->zip;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getWebsite(): string
    {
        return $this->website;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): string
    {
        return $this->updatedAt;
    }

    public function getLocalization(): Collection
    {
        return $this->localization;
    }

    public function getCategory(): PlaceCategory
    {
        return $this->category;
    }

    public function getCity(): City
    {
        return $this->city;
    }

    public function getRating(): ?float
    {
        return $this->rating;
    }

    public function getReviews(): Collection
    {
        return $this->reviews;
    }

    public function getFeatures(): Collection
    {
        return $this->features;
    }
}
