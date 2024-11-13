<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreThemeRequest extends FormRequest
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
            'themes' => 'required|array|min:1',
            'themes.*.name' => 'required|string|max:255|unique:themes,name', // Validate each theme name
        ];
    }

    public function messages(): array
    {
        return [
            'themes.required' => 'Please add at least one theme.',
            'themes.*.name.required' => 'Each theme must have a name.',
            'themes.*.name.string' => 'The theme name must be a valid string.',
            'themes.*.name.max' => 'The theme name cannot exceed 255 characters.',
            'themes.*.name.unique' => 'This theme name already exists. Please choose a different name.',
        ];
    }
}
