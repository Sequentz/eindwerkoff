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
            'name' => 'required|string|max:255|unique:words,name',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The word name is required.',
            'name.string' => 'The word name must be a valid string.',
            'name.max' => 'The word name cannot exceed 255 characters.',
            'name.unique' => 'This word name already exists. Please choose a different name.',
        ];
    }
}
