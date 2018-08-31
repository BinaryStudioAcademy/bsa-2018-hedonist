<?php

namespace Hedonist\Actions\UserTaste;

use Illuminate\Support\Collection;

class GetTastesAutocompleteResponse
{
    private $tasteCollection;

    public function __construct(Collection $tasteCollection)
    {
        $this->tasteCollection = $tasteCollection;
    }

    public function getTasteCollection(): Collection
    {
        return $this->tasteCollection;
    }
}