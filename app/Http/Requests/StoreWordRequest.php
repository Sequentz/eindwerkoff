<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWordRequest extends FormRequest
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
            // Validate for each word in the array
            'words' => 'required|array',
            'words.*.name' => 'required|string|max:255|unique:words,name',
            'words.*.themes' => 'nullable|array',
            'words.*.themes.*' => 'exists:themes,id', // Validate that each selected theme exists in the themes table
        ];
    }

    /**
     * Custom error messages for validation.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'words.required' => 'Please add at least one word.',
            'words.*.name.required' => 'The word name is required.',
            'words.*.name.string' => 'The word name must be a valid string.',
            'words.*.name.max' => 'The word name cannot exceed 255 characters.',
            'words.*.name.unique' => 'This word name already exists. Please choose a different name.',
            'words.*.themes.exists' => 'Selected themes are not valid.',
        ];
    }
}
