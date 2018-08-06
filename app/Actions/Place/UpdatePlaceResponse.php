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
     * Gets CreatorEmail.
     *
     * @return mixed
     */
    public function getCreatorEmail()
    {
        return $this->creatorEmail;
    }

    /**
     * Gets Category.
     *
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Gets City.
     *
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
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

    /**
     * Gets CreatedAt.
     *
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Gets UpdatedAt.
     *
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}
