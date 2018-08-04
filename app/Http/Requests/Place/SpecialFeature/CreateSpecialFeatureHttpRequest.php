<?php

namespace Hedonist\Http\Requests\Place\SpecialFeature;

use Hedonist\Http\Requests\JsonRequest;

class CreateSpecialFeatureHttpRequest extends JsonRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|unique:places_features|max:45',
        ];
    }
}
