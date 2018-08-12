<?php

namespace Hedonist\Actions\Place\GetPlaceItem;

use Hedonist\Entities\Place\Place;

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

    public function __construct(Place $place)
    {
        $this->id = $place->id;
        $this->creator_id = $place->creator_id;
        $this->category_id = $place->category_id;
        $this->city_id = $place->city_id;
        $this->longitude = $place->longitude;
        $this->latitude = $place->latitude;
        $this->zip = $place->zip;
        $this->address = $place->address;
        $this->phone = $place->phone;
        $this->website = $place->website;
        $this->createdAt = $place->created_at;
        $this->updatedAt = $place->updated_at;
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
}
