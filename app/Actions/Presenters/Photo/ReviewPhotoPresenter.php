<?php

namespace Hedonist\Actions\Presenters\Photo;

use Hedonist\Actions\Presenters\PresentsCollection;
use Hedonist\Entities\Review\ReviewPhoto;

class ReviewPhotoPresenter
{
    use PresentsCollection;

    public function present(ReviewPhoto $photo)
    {
        return [
            'id' => $photo->id,
            'description' => $photo->description,
            'width' => $photo->width,
            'height' => $photo->height,
            'img_url' => $photo->img_url
        ];
    }
}