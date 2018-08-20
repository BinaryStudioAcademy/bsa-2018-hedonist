<?php

namespace Hedonist\Http\Requests\Place;

use Illuminate\Foundation\Http\FormRequest;

class PlaceSearchRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'filter.category' => 'nullable|int',
            'filter.location' => 'nullable|string',
            'page' => 'int|min:1',
        ];
    }
}