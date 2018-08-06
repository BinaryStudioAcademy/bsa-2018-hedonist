<?php

namespace Hedonist\Http\Requests\Place\Rate;

use Hedonist\Http\Requests\JsonRequest;

class SetRatingHttpRequest extends JsonRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() : bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() : array
    {

        return [
            'place_id' => 'required|integer',
            'value' => 'required|numeric|min:0.0|max:10.0',
        ];
    }
}
