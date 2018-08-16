<?php

namespace Hedonist\Http\Requests\Review;

use Illuminate\Foundation\Http\FormRequest;

class ReviewPhotoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'review_id' => 'required|integer',
            'description' => 'required|string|max:255',
            'img_url' => 'required|image|max:2048',
            'width' => 'integer',
            'height' => 'integer'
        ];
    }
}