<?php

namespace Hedonist\Http\Requests\Place;

use Hedonist\Http\Requests\JsonRequest;
use Hedonist\Rules\Phone;

class ValidateAddPlaceRequest extends JsonRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'longitude'   => 'required|numeric',
            'latitude'    => 'required|numeric',
            'zip'         => 'required|numeric',
            'address'     => 'required|max:255',
            'creator_id'  => 'required|numeric',
            'category_id' => 'required|numeric',
            'city_id'     => 'required|numeric',
            'phone'       => [new Phone()],
            'website'     => 'max:255'
        ];
    }
}