<?php

namespace Hedonist\Http\Requests\UserList;

use Illuminate\Foundation\Http\FormRequest;

class UserListUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'            => 'sometimes|nullable|string|max:255',
            'image'           => 'sometimes|nullable|image|max:5000',
            'attached_places' => 'nullable|array',
        ];
    }
}
