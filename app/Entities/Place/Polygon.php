<?php

namespace Hedonist\Entities\Place;

class Polygon
{
    const FROM_STRING_PATTERN = '/^[0-9]+(\.[0-9]+)?,[0-9]+(\.[0-9]+)?$/';
    const ERROR_MESSAGE = 'The polygon has an incorrect format';

    public static function polygonFormatter(string $polygon): string
    {
        if (strpos($polygon, ';') === false) {
            throw new \InvalidArgumentException(self::ERROR_MESSAGE);
        }
        $polygonPoints = explode(';', $polygon);
        foreach ($polygonPoints as $key => $point) {
            if (preg_match(self::FROM_STRING_PATTERN, $point) == false) {
                throw new \InvalidArgumentException(self::ERROR_MESSAGE);
            }
            $polygonPoints[$key] = str_replace(',', ' ', $point);
        }

        return implode(',', $polygonPoints);
    }
}