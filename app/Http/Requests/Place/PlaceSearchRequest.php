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
            'filter.top_reviewed' => 'nullable|boolean',
            'filter.top_rated' => 'nullable|boolean',
            'filter.checkin' => 'nullable|boolean',
            'filter.saved' => 'nullable|boolean',
            'filter.recommended' => 'nullable|boolean',
            'filter.polygon' => 'nullable|string',
            'filter.name' => 'nullable|string',
            'page' => 'int|min:1',
        ];
    }
}