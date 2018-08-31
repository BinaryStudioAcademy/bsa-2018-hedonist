<?php

namespace Hedonist\Http\Requests\UserList;

use Illuminate\Foundation\Http\FormRequest;

class UserListAddRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
            return [
                'name'            => 'required|string|max:255',
                'image'           => 'sometimes|image|max:5000',
                'attached_places' => 'nullable|array',
            ];
    }
}
