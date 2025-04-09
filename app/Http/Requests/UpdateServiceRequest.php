<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateServiceRequest extends FormRequest
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
            'category_id' => ['required'],
            'title' => ['required', 'string', 'max:255'],
            'icon' => ['nullable', 'image', 'max:500'],
            'preview' => ['nullable', 'image', 'max:2048'],
            'overview' => ['required', 'string', 'max:3000'],
            'faqs' => ['required'],
            'is_active' => ['nullable'],
            'is_featured' => ['nullable'],
        ];
    }
}
