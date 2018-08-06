<?php

namespace Hedonist\Http\Requests\Place;


use Hedonist\Http\Requests\JsonRequest;

class ValidateUpdatePlaceRequest extends JsonRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'longitude'   => 'required|numeric|min:-180|max:180',
            'latitude'    => 'required|numeric|min:-90|max:90',
            'zip'         => 'required|numeric|min:0',
            'address'     => 'required|max:255',
            'creator_id'  => 'required|numeric|min:1',
            'category_id' => 'required|numeric|min:1',
            'city_id'     => 'required|numeric|min:1',
        ];
    }
}
