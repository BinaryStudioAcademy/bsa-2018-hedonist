<?php

namespace Hedonist\Actions\Place\SavePlaceCategory;

class SavePlaceCategoryRequest
{
    private $id;
    private $name;

    public function __construct(string $name, int $id = null)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

}