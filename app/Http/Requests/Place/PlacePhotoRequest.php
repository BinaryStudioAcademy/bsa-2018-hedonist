<?php

namespace Hedonist\Http\Requests\Place;

use Hedonist\Http\Requests\JsonRequest;

class PlacePhotoRequest extends JsonRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'creator_id' => 'required|integer',
            'description' => 'required|string|max:255',
            'img_url' => 'required|image',
            'place_id' => 'required|integerapp/Entities/Place/PlacePhoto.php '
        ];
    }
}