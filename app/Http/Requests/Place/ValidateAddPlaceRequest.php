<?php

namespace Hedonist\Http\Requests\Place;

use Hedonist\Http\Requests\JsonRequest;
use Hedonist\Rules\Phone;

class ValidateAddPlaceRequest extends JsonRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'longitude'    => 'required|numeric',
            'latitude'     => 'required|numeric',
            'city'         => 'required|string',
            'zip'          => 'required|numeric',
            'address'      => 'required|max:255',
            'localization' => 'required|string',
            'photos'       => 'array',
            'phone'        => [new Phone()],
            'website'      => 'required|max:255',
            'facebook'     => 'max:255',
            'instagram'    => 'max:255',
            'twitter'      => 'max:255',
            'menu_url'     => 'max:255',
            'category_id'  => 'required|numeric',
            'tags'         => 'required|array',
            'features'     => 'required|array',
            'creator_id'   => 'required|numeric',
            'worktime'     => 'required|string'
        ];
    }
}