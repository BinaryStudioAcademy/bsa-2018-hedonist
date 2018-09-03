<?php

namespace Hedonist\Entities\Place;

class Location
{
    const MIN_LONGITUDE = -180;
    const MAX_LONGITUDE = 180;

    const MIN_LATITUDE = -90;
    const MAX_LATITUDE = 90;

    const EARTH_RADIUS_IN_KM = 6371;
    const RADIUS = 5;

    const FROM_STRING_PATTERN = '/^[0-9]+(\.[0-9]+)?,[0-9]+(\.[0-9]+)?$/';

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

    public static function fromString(string $location): self
    {
        if (preg_match(self::FROM_STRING_PATTERN, $location) == false) {
            throw new \InvalidArgumentException('The location has an incorrect format');
        }
        $locationToArray = explode(',', $location);
        $longitude = $locationToArray[0];
        $latitude = $locationToArray[1];

        return new self($longitude, $latitude);
    }
}
