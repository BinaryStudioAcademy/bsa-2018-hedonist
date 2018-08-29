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
            'name'            => 'required|string|max:255',
            'image'           => 'required|image',
            'attached_places' => 'nullable|array',
        ];
    }
}
