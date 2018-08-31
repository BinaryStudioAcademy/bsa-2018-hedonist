<?php

namespace Hedonist\Actions\UserTaste;

class GetTastesAutocompleteRequest
{
    private $query;

    public function __construct(string $query)
    {
        $this->query = $query;
    }

    public function getQuery(): string
    {
        return $this->query;
    }
}