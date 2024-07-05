<?php

namespace App\Http\Requests\Performance;

use Illuminate\Foundation\Http\FormRequest;

class PerformanceRequest extends FormRequest
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
        switch ($this->method()) {
            case 'POST':
                return [
                    'student_id' => ['required'],
                    'type' => ['required'],
                    'points' => ['required'],
                    'remark' => ['required'],
                ];
            case 'PUT':
                return [
                    'student_id' => ['required'],
                    'type' => ['required'],
                    'points' => ['required'],
                    'remark' => ['required'],
                ];
            default:
                return [];
        }
    }
    
    public function messages()
    {
        return [
            'student_id.required' => 'The student field is required',
        ];
    }
}