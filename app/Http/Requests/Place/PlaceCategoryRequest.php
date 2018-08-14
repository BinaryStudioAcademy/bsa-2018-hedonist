<?php

namespace Hedonist\Http\Requests\Place;

use Illuminate\Foundation\Http\FormRequest;

class PlaceCategoryRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'nullable|string|min:0|max:255',
            'limit' => 'nullable|int',
        ];
    }
}