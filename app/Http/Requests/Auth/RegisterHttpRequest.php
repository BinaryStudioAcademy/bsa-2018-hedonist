<?php

namespace Hedonist\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterHttpRequest extends FormRequest
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
            'email' => 'required|email',
            'password' => 'required|min:6|string',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'language' => 'required|string',
        ];
    }
}
