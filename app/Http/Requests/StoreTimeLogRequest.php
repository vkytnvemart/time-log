<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTimeLogRequest extends FormRequest
{
    public function authorize()
    {
        return true; 
    }

    public function rules()
    {
        return [
            'work_date' => 'required|date|before_or_equal:today',
            'description.*' => 'required|string|max:255',
            'hours.*' => 'required|integer|min:0|max:10',
            'minutes.*' => 'required|integer|min:0|max:59',
        ];
    }

    public function messages()
    {
        return [
            'work_date.before_or_equal' => 'Work date cannot be a future date.',
            'description.*.required' => 'Each task must have a description.',
            'hours.*.max' => 'Maximum 10 hours per task.',
            'minutes.*.max' => 'Maximum 59 minutes per task.',
        ];
    }
}
