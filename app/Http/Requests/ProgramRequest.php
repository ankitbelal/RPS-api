<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProgramRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:programs,code',
            'duration_years' => 'required|integer',
            'total_semesters' => 'required|integer',
            'total_subjects' => 'required|integer',
            'description' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The program name is required.',
            'code.required' => 'The program code is required.',
            'code.unique' => 'The program code must be unique.',
            'duration_years.required' => 'The duration in years is required.',
            'total_semesters.required' => 'The total number of semesters is required.',
            'total_subjects.required' => 'The total number of subjects is required.',
        ];
    }
}
