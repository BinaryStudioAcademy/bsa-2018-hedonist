<?php

namespace Hedonist\Http\Requests\UserTaste;

use Illuminate\Foundation\Http\FormRequest;

class AddTasteHttpRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            "name" => 'required|string|min:3|max:20',
        ];
    }
}
