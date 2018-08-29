<?php

namespace Hedonist\Entities\Place;

class Polygon
{
    const POINT_STRING_PATTERN = '/^[0-9]+(\.[0-9]+)?,[0-9]+(\.[0-9]+)?$/';
    const ERROR_MESSAGE = 'The polygon has an incorrect format';

    private $polygonPoints = [];

    public function __construct(string $polygon)
    {
        if (strpos($polygon, ';') === false) {
            throw new \InvalidArgumentException(self::ERROR_MESSAGE);
        }
        $polygonPoints = explode(';', $polygon);
        foreach ($polygonPoints as $key => $point) {
            if (preg_match(self::POINT_STRING_PATTERN, $point) == false) {
                throw new \InvalidArgumentException(self::ERROR_MESSAGE);
            }
            $this->polygonPoints[] = str_replace(',', ' ', $point);
        }
    }

    public function toString(): string
    {
        return implode(',', $this->polygonPoints);
    }

    public function toArray(): array
    {
        return $this->polygonPoints;
    }
}