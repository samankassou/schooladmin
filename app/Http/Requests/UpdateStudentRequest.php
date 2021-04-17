<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStudentRequest extends FormRequest
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
            'firstname' => 'required',
            'lastname' => 'required',
            'dob' => 'required',
            'place_of_birth' => 'required',
            'gender' => 'required',
            'classroom' => 'required|exists:classrooms,id',
            'mother_name' => 'required',
            'father_name' => 'sometimes|string',
        ];
    }
}
