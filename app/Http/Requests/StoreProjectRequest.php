<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
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
         
            'preview' => ['required', 'image', 'max:1024'],
            'banner_preview' => ['required', 'image', 'max:1024'],
            'description' => ['required', 'string'],
            'overview' => ['required', 'string'],
            'output' => ['required', 'string'],
            'client' => ['nullable', 'string', 'max:255'],
            'preview_link' => ['nullable', 'string', 'max:255'],
            'is_active' => ['required'],
            'is_featured' => ['required'],
           
        ];
    }

    public function attributes()
    {
        return [
            'output' => 'solution and result'
        ];
    }
}
