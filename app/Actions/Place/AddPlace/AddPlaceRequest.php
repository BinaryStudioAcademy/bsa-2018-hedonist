<?php

namespace Hedonist\Actions\Place\AddPlace;

class AddPlaceRequest
{
    private $creatorId;
    private $categoryId;
    private $city;
    private $longitude;
    private $latitude;
    private $zip;
    private $address;
    private $phone;
    private $website;

    public function __construct(
        int $creatorId,
        int $categoryId,
        String $city,
        float $longitude,
        float $latitude,
        int $zip,
        string $address,
        string $phone,
        string $website,
        array $photos
    ) {
        $this->creatorId = $creatorId;
        $this->categoryId = $categoryId;
        $this->city = $city;
        $this->longitude = $longitude;
        $this->latitude = $latitude;
        $this->zip = $zip;
        $this->address = $address;
        $this->phone = $phone;
        $this->website = $website;
        $this->photos = $photos;
    }

    public function getCreatorId(): int
    {
        return $this->creatorId;
    }

    public function getCategoryId(): int
    {
        return $this->categoryId;
    }

    public function getCity(): array
    {
        $cityObj = json_decode($this->city, true);
        return [
            'name' => $cityObj['text_en'],
            'lng'  => $cityObj['center'][0],
            'lat'  => $cityObj['center'][1],
        ];
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

    public function getPhotos(): array
    {
        return $this->photos;
    }

    public function toArray(): array
    {
        return [
            'creator_id'    => $this->getCreatorId(),
            'category_id'   => $this->getCategoryId(),
            'city'          => $this->getCity(),
            'longitude'     => $this->getLongitude(),
            'latitude'      => $this->getLatitude(),
            'zip'           => $this->getZip(),
            'address'       => $this->getAddress(),
            'phone'         => $this->getPhone(),
            'website'       => $this->getWebsite(),
            'photos'        => $this->getPhotos()
        ];
    }
}
