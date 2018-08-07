<?php

namespace Hedonist\Http\Requests\Place\Rate;

use Hedonist\Http\Requests\JsonRequest;

class SetRatingHttpRequest extends JsonRequest
{
    public function authorize() : bool
    {
        return true;
    }

    public function rules() : array
    {
        return [
            'place_id' => 'required|integer|min:1',
            'rating' => 'required|integer|min:0|max:10',
        ];
    }
}
