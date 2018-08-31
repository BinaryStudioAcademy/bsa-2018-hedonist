<?php

namespace Hedonist\Actions\Presenters\Taste;

use Hedonist\Actions\Presenters\PresentsCollection;
use Hedonist\Actions\UserTaste\GetTastesAutocompleteResponse;
use Hedonist\Entities\User\Taste;

class TasteAutocompletePresenter
{
    use PresentsCollection;

    public function present(GetTastesAutocompleteResponse $response): array
    {
        return $response->getTasteCollection()->map(function (Taste $taste) use ($response) {
            return $taste->name;
        })->toArray();
    }
}