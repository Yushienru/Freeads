<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdUpdate extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    
    public function rules()
    {
        return [
            'title' => ['required', 'string', 'max:100'],
            'texte' => ['required', 'string', 'max:1000'],
        ];
    }
}