<?php

namespace Hedonist\Actions\Place\GetPlaceCollectionForAutoComplete;

class GetPlaceCollectionForAutoCompleteRequest
{
    private $name;
    private $location;

    public function __construct(
        string $name,
        ?string $location
    ) {
        $this->name = $name;
        $this->location = $location;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
