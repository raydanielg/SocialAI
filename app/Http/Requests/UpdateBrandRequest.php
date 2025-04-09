<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use function GuzzleHttp\Promise\all;

class UpdateBrandRequest extends FormRequest
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
            'name' => 'required|string',
            'slogan' => 'required|string',
            'strategy' => 'required|string',
            'description' => 'required|string',
            'voices' => 'required|array',
            'audiences' => 'required|array',
            'audiences.*.text' => 'required|string',
            'color.primary' => 'required|string',
            'color.secondary' => 'required|string',
            'identities.mission' => 'required|string',
            'identities.vision' => 'required|string',
            'identities.values' => 'required|string',
            'voices.message' => 'required|string',
            'voices.tones' => 'required|array',
            'voices.tones.*.text' => 'required|string',
            'logo' => request()->hasFile('logo') ? ['image', 'mimes:png,jpg,jpeg'] : 'nullable',
        ];
    }

    public function messages(): array
    {
        return [
            'voices.message' => 'Message field is required',
            'identities.mission' => 'Mission field is required',
            'identities.vision' => 'Vision field is required',
            'identities.values' => 'Values field is required',
            'color.primary' => 'Primary color field is required',
            'color.secondary' => 'Secondary color field is required',
            'audiences.*.text.required' => 'Segment is required',
            'voices.tones.*.text.required' => 'Tone is required',
        ];
    }
}
