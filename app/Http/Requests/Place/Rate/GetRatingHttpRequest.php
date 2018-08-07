<?php

namespace Hedonist\Http\Requests\Place\Rate;

use Hedonist\Http\Requests\JsonRequest;

class GetRatingHttpRequest extends JsonRequest
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

        $slug_id = $this->route()->parameter('id');

        if ($slug_id) {
            return [
            ];
        }

        return [
            'user_id' => 'integer|min:1',
            'place_id' => 'required|integer|min:0',
        ];
    }
}
