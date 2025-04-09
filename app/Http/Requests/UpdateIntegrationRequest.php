<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateIntegrationRequest extends FormRequest
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
            'preview' => ['nullable', 'image', 'max:5000'],
            'bg_color' => ['nullable'],
            'preview_2' => ['nullable', 'image', 'max:5000'],

            'is_active' => ['nullable'],
            'is_featured' => ['nullable'],
        ];
    }

    public function attributes(): array
    {
        return [
            'preview' => __('Preview Icon'),
            'bg_color' => __('Icon Background Color'),
            'preview_2' => __('Preview Image'),
        ];
    }
}
