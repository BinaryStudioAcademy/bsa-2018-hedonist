<?php

namespace Hedonist\Actions\Presenters\City;

use Hedonist\Entities\Place\City;

class CityPresenter
{
    public function present(City $city): array
    {
        return [
            $city->id,
            $city->name
        ];
    }
}