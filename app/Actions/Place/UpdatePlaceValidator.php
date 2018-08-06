<?php

namespace Hedonist\Actions\Place;


use Illuminate\Support\Facades\Validator;

class UpdatePlaceValidator
{
    public function validate(UpdatePlaceRequest $request): \Illuminate\Contracts\Validation\Validator
    {
        return Validator::make($request->all(), [
            'longitude'   => 'required|numeric|min:-180|max:180',
            'latitude'    => 'required|numeric|min:-90|max:90',
            'zip'         => 'required|numeric|min:0',
            'address'     => 'required|max:255',
            'creator_id'  => 'required|numeric|min:1',
            'category_id' => 'required|numeric|min:1',
            'city_id'     => 'required|numeric|min:1',
        ]);
    }
}
