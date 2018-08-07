<?php

namespace Hedonist\Actions\Place;

class GetPlaceItemResponse
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
        string $creatorEmail,
        string $categoryName,
        string $city,
        float $longitude,
        float $latitude,
        int $zip,
        string $address,
        string $createdAt,
        string $updatedAt
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

    public function getCreatorEmail(): string
    {
        return $this->creatorEmail;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function getCity(): string
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

    public function getAddress(): string
    {
        return $this->address;
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
