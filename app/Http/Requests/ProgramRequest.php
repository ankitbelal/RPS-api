<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Helpers\ApiResponse; // your helper

class ProgramRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

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
            'code.unique' => 'The program with this code already exists.', // custom message
            'duration_years.required' => 'The duration in years is required.',
            'total_semesters.required' => 'The total number of semesters is required.',
            'total_subjects.required' => 'The total number of subjects is required.',
        ];
    }

    // Override failedValidation to use your ApiResponse helper
    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();

        // Check if code field has unique error and set 409, else 422
    $status = $errors->has('code') && str_contains($errors->first('code'), 'already exists') ? 409 : 422;

        throw new HttpResponseException(
            ApiResponse::failedResponse(
                "program registration failed",
                $errors,
                $status
            )
        );
    }
}
