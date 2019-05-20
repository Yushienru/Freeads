<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EmailUpdate extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    
    public function rules()
    {
        return [
            'email' => [
                'required', 'string', 'email', 'max:255',
                Rule::unique('users')->ignore(auth()->id()),
            ],
        ];
    }
}