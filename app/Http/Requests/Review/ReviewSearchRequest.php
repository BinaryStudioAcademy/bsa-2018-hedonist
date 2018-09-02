<?php

namespace Hedonist\Http\Requests\Review;

use Illuminate\Foundation\Http\FormRequest;

class ReviewSearchRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'filter.text' => 'nullable|string',
            'sort' => 'nullable|string',
            'place_id' => 'nullable|int|min:1',
            'order' => 'nullable|string|in:asc,desc',
            'page' => 'int|min:1',
        ];
    }
}