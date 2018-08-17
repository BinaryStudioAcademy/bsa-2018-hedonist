<?php

namespace Hedonist\Http\Requests\Place;

use Illuminate\Foundation\Http\FormRequest;

class PlacePhotoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'creator_id' => 'required|integer',
            'description' => 'required|string|max:255',
            'img_url' => 'required|image|max:2048',
            'place_id' => 'required||exists:places,id'
        ];
    }
}