<?php

namespace Hedonist\Actions\Place\GetPlaceCollectionForAutoComplete;

class GetPlaceCollectionForAutoCompleteRequest
{
    private $name;
    private $polygon;

    public function __construct(
        ?string $name,
        ?string $polygon
    ) {
        $this->name = $name;
        $this->polygon = $polygon;
    }

    public function getPolygon(): ?string
    {
        return $this->polygon;
    }

    public function getName(): ?string
    {
        return $this->name;
    }
}
