<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTimeLogRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'description' => 'required|string|max:255',
            'hours' => 'required|integer|min:0|max:10',
            'minutes' => 'required|integer|min:0|max:59',
        ];
    }

    public function messages()
    {
        return [
            'hours.max' => 'Cannot exceed 10 hours.',
            'minutes.max' => 'Cannot exceed 59 minutes.',
        ];
    }
}
