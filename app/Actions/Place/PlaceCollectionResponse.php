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

    public function getId()
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

    public function getLongitude()
    {
        return $this->longitude;
    }

    public function getLatitude()
    {
        return $this->latitude;
    }

    public function getZip()
    {
        return $this->zip;
    }

    public function getAddress()
    {
        return $this->address;
    }
}
