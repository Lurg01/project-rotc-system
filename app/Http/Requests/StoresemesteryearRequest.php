<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoresemesteryearRequest extends FormRequest
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
            'student_id'=> [
                "required",
            ],
            'semester'=> [
                "required",
                "string",
            ],
            'year'=> [
                "required",
                "string",
            ],
        ];
    }
}
