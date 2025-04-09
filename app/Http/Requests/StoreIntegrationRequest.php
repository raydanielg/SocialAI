<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreIntegrationRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'short_description' => ['required', 'string', 'max:255'],
            'long_description' => ['required'],
            'preview' => ['required', 'image', 'max:5000'],
            'bg_color' => ['required',],
            'preview_2' => ['required', 'image', 'max:5000'],

            'is_active' => ['nullable'],
            'is_featured' => ['nullable'],
        ];
    }
}
