<?php

namespace Hedonist\Http\Requests\Place\Checkin;

use Hedonist\Http\Requests\JsonRequest;

class SetCheckinHttpRequest extends JsonRequest
{
    public function authorize() : bool
    {
        return true;
    }

    public function rules() : array
    {
        return [
            'place_id' => 'required|integer',
        ];
    }
}