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
            'place_id' => 'required|integer',
            'rating' => 'required',
        ];
    }
}
