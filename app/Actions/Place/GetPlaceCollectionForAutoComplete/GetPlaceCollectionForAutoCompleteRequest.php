<?php

namespace Hedonist\Actions\Place\GetPlaceCollectionForAutoComplete;

class GetPlaceCollectionForAutoCompleteRequest
{
    private $location;
    private $name;

    public function __construct(
        ?string $location,
        ?string $name
    ) {
        $this->location = $location;
        $this->name = $name;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function getName(): ?string
    {
        return $this->name;
    }
}
