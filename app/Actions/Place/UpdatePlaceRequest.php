<?php

namespace Hedonist\Actions\Place;


class UpdatePlaceRequest
{
    private $id;
    private $creatorId;
    private $categoryId;
    private $cityId;
    private $longitude;
    private $latitude;
    private $zip;
    private $address;

    public function __construct(
        int $id,
        int $creatorId,
        int $categoryId,
        int $cityId,
        float $longitude,
        float $latitude,
        int $zip,
        $address
    ) {
        $this->id = $id;
        $this->creatorId = $creatorId;
        $this->categoryId = $categoryId;
        $this->cityId = $cityId;
        $this->longitude = $longitude;
        $this->latitude = $latitude;
        $this->zip = $zip;
        $this->address = $address;
    }

    /**
     * Gets Id.
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Gets CreatorId.
     *
     * @return int
     */
    public function getCreatorId(): int
    {
        return $this->creatorId;
    }

    /**
     * Gets CategoryId.
     *
     * @return int
     */
    public function getCategoryId(): int
    {
        return $this->categoryId;
    }

    /**
     * Gets CityId.
     *
     * @return int
     */
    public function getCityId(): int
    {
        return $this->cityId;
    }

    /**
     * Gets Longitude.
     *
     * @return float
     */
    public function getLongitude(): float
    {
        return $this->longitude;
    }

    /**
     * Gets Latitude.
     *
     * @return float
     */
    public function getLatitude(): float
    {
        return $this->latitude;
    }

    /**
     * Gets Zip.
     *
     * @return int
     */
    public function getZip(): int
    {
        return $this->zip;
    }

    /**
     * Gets Address.
     *
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }
}
