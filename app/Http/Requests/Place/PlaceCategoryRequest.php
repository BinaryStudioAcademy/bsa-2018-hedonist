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
            'name' => 'required|string|max:255'
        ];
    }
}