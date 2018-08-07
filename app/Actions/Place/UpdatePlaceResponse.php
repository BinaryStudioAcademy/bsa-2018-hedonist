<?php

namespace Hedonist\Actions\Place;

class UpdatePlaceResponse
{
    private $id;
    private $creatorEmail;
    private $category;
    private $city;
    private $longitude;
    private $latitude;
    private $zip;
    private $address;
    private $createdAt;
    private $updatedAt;

    public function __construct(
        int $id,
        $creatorEmail,
        $categoryName,
        $city,
        float $longitude,
        float $latitude,
        int $zip,
        $address,
        $createdAt,
        $updatedAt
    ) {
        $this->id = $id;
        $this->creatorEmail = $creatorEmail;
        $this->category = $categoryName;
        $this->city = $city;
        $this->longitude = $longitude;
        $this->latitude = $latitude;
        $this->zip = $zip;
        $this->address = $address;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCreatorEmail()
    {
        return $this->creatorEmail;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function getCity()
    {
        return $this->city;
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

    public function getAddress()
    {
        return $this->address;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}
