<?php

namespace Hedonist\Entities\Place;


class Location
{
    const MIN_LONGITUDE = -180;
    const MAX_LONGITUDE = 180;

    const MIN_LATITUDE = -90;
    const MAX_LATITUDE = 90;

    private $longitude;
    private $latitude;

    public function __construct(float $longitude, float $latitude)
    {
        if ($longitude < self::MIN_LONGITUDE || $longitude > self::MAX_LONGITUDE) {
            throw new \InvalidArgumentException('Longitude is overrange');
        }

        if ($latitude < self::MIN_LATITUDE || $latitude > self::MAX_LATITUDE) {
            throw new \InvalidArgumentException('Latitude is overrange');
        }

        $this->longitude = $longitude;
        $this->latitude = $latitude;
    }

    public function getLongitude(): float
    {
        return $this->longitude;
    }

    public function getLatitude(): float
    {
        return $this->latitude;
    }
}
