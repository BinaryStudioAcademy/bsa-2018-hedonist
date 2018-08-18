<?php

namespace Hedonist\Actions\Presenters\Photo;

use Hedonist\Actions\Presenters\PresentsCollectionTrait;
use Hedonist\Entities\Place\PlacePhoto;

class PlacePhotoPresenter
{
    use PresentsCollectionTrait;

    public function present(PlacePhoto $photo): array
    {
        return [
            'id' => $photo->id,
            'description' => $photo->description,
            'img_url' => $photo->img_url,
            'creator_id' => $photo->creator_id
        ];
    }
}