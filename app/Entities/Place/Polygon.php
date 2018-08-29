<?php

namespace Hedonist\Entities\Place;

class Polygon
{
    const POINT_STRING_PATTERN = '/^[0-9]+(\.[0-9]+)?,[0-9]+(\.[0-9]+)?$/';
    const ERROR_MESSAGE = 'The polygon has an incorrect format';

    private $polygon = [];

    public function __construct(array $polygon)
    {
        $this->polygon = $polygon;
    }

    public static function fromString(string $string): self
    {
        self::validateString($string);
        $polygonPoints = explode(';', $string);

        $polygon = array_map(
            function (string $point) {
                return str_replace(',', ' ', $point);
            },
            $polygonPoints
        );

        return new self($polygon);
    }

    public function toString(): string
    {
        return implode(',', $this->polygon);
    }

    public function toArray(): array
    {
        return $this->polygon;
    }

    private static function validateString(string $string): void
    {
        if (strpos($string, ';') === false) {
            throw new \InvalidArgumentException(self::ERROR_MESSAGE);
        }
        $polygonPoints = explode(';', $string);
        foreach ($polygonPoints as $key => $point) {
            if (preg_match(self::POINT_STRING_PATTERN, $point) == false) {
                throw new \InvalidArgumentException(self::ERROR_MESSAGE);
            }
        }
    }
}