<?php

namespace Hedonist\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserInfoHttpRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'first_name' => 'max:255',
            'last_name' => 'max:255',
            'date_of_birth' => 'date_format:Y/m/d',
            'phone_number' => 'max:25',
            'avatar_url' => 'image',
            'facebook_url' => 'url',
            'instagram_url' => 'url',
            'twitter_url' => 'url',
        ];
    }
}
