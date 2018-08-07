<?php

namespace Hedonist\Http\Requests\UserList;

use Illuminate\Foundation\Http\FormRequest;

class UserListRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'user_id' => 'required|integer',
            'name' => 'required|string|max:255',
            'img_url' => 'required|url|max:255',
        ];
    }
}
