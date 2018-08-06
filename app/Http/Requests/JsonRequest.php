<?php

namespace Hedonist\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

abstract class JsonRequest extends FormRequest
{
    public function wantsJson() : bool
    {
        return true;
    }
}