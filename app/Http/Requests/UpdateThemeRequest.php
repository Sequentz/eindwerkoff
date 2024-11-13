<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateThemeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Adjust to your authorization logic if needed
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('themes', 'name')->ignore($this->route('theme')),
            ],
        ];
    }

    /**
     * Customize the error messages for validation rules.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The theme name is required.',
            'name.string' => 'The theme name must be a valid string.',
            'name.max' => 'The theme name cannot exceed 255 characters.',
            'name.unique' => 'This theme name already exists. Please choose a different name.',
        ];
    }
}
