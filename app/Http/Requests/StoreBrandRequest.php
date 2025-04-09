<?php

namespace App\Http\Requests;

use App\Rules\EnglishLanguage;
use Illuminate\Foundation\Http\FormRequest;

class StoreBrandRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'form.name' => ['required', 'string', 'max:255', new EnglishLanguage],
            'form.description' => ['required', 'string', new EnglishLanguage],
            'form.logo' => $this->hasFile('form.logo') ? 'required|image' : 'nullable|string',
        ];
    }

    public function attributes()
    {
        return [
            'form.name' => 'name',
            'form.description' => 'description',
            'form.logo' => 'logo',
        ];
    }
}
