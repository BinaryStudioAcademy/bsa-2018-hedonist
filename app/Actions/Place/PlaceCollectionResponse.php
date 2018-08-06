<?php

namespace Hedonist\Actions\Place;

use Hedonist\Entities\Place\Place;
use Illuminate\Database\Eloquent\Collection;

class PlaceCollectionResponse
{
    private $id;
    private $creatorEmail;
    private $category;
    private $city;
    private $longitude;
    private $latitude;
    private $zip;
    private $address;

    public function __construct(Collection $place)
    {
        $this->id = $place->id;
        $this->creatorEmail = $place->creator->email;
        $this->category = $place->category->name;
        $this->city = $place->city->name;
        $this->longitude = $place->longitude;
        $this->latitude = $place->latitude;
        $this->zip = $place->zip;
        $this->address = $place->address;
    }

    /**
     * Gets Id.
     *
     * @return mixed
     */
    public function getId()
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
     * @return mixed
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Gets Latitude.
     *
     * @return mixed
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Gets Zip.
     *
     * @return mixed
     */
    public function getZip()
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
