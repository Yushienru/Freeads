<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MessageAd extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'message' => ['required', 'string', 'max:500'],
            'email' => ['sometimes', 'required', 'string', 'email', 'max:255'],
        ];
    }
}