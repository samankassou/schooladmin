<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClassroomRequest extends FormRequest
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
            'level' => 'required|exists:levels,id',
            'name' => 'required|string|unique:classrooms,name,'.$this->classroom->id,
            'head_teacher' => 'sometimes|exists:users,id'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'level.exists' => 'Ce niveau est invalide',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'level' => 'niveau',
            'name' => 'Nom',
            'head_teacher' => 'Professeur'
        ];
    }
}
