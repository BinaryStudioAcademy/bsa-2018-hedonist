<?php

namespace Hedonist\Actions\Presenters\Localization;

use Hedonist\Entities\Localization\PlaceTranslation;

class LocalizationPresenter
{
    public function present(PlaceTranslation $translation):array
    {
        return [
            'name' => $translation->place_name,
            'description' => $translation->place_description,
            'language' =>  $translation->language->code ?? 'UNKNOWN'
        ];
    }
}