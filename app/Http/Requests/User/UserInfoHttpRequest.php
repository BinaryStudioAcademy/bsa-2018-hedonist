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
            "first_name" => 'max:255',
            "last_name" => 'max:255',
            "date_of_birth" => 'nullable|date_format:Y/m/d',
            "phone_number" => 'nullable|max:25',
            "avatar" => 'nullable|image',
            "facebook_url" => 'nullable|url',
            "instagram_url" => 'nullable|url',
            "twitter_url" => 'nullable|url',
            'old_password' => 'nullable|min:6|string',
            'new_password' =>'nullable|min:6|string'
        ];
    }
}
