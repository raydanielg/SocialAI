<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAiTemplateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules()
    {
        $rules = [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:1000'],
            'preview' => ['required', 'image', 'max:2048'],
            'icon' => ['required', 'image', 'max:2048'],
            'status' => ['required'],
            'prompt' => 'required',
            'prompt_type' => 'required',
            'credit_charge' => 'required|numeric|between:0,999.99',
            'fields.*.type' => ['required'],
            'fields.*.name' => ['required'],
            'fields.*.placeholder' => ['required'],
            'fields.*.value' => ['nullable'],
        ];

        if ($this->prompt_type == 'text') {
            $rules += [
                'meta.max_token' => 'required|integer',
                'meta.max_word' => 'required|integer',
                'meta.model' => 'required|string',
            ];
        }
        if ($this->prompt_type == 'voice_clone') {
            $rules += [
                'meta.decoder_iterations' => 'required|integer|max:100',
                'meta.voice_id' => 'required|string',
            ];
        }
        if ($this->prompt_type == 'audio') {
            $rules += [
                'meta.decoder_iterations' => 'required|integer|max:100',
            ];
        }
        if ($this->prompt_type == 'image') {
            $rules += [
                'ai_model' => 'required|string|in:stablediffusion,stability_ai,dalle_3',
                'meta.negative_prompt' => 'nullable|string',
                'meta.seed' => 'nullable|integer',
            ];
            if ($this->ai_model === 'stablediffusion') {
                $rules += [
                    'meta.steps' => 'nullable|integer',
                    'meta.image_height' => 'required|integer|max:1024',
                    'meta.image_width' => 'required|integer|max:1024',
                    'meta.guidance_scale' => 'nullable|numeric',
                ];
            }
            if ($this->ai_model === 'stability_ai') {
                $rules += [
                    'meta.aspect_ratio' => 'required|string',
                ];
            }
            if ($this->ai_model === 'dalle_3') {
                $rules += [
                    'meta.image_size' => 'required|string',
                    'meta.image_quality' => 'required|string',
                ];
            }
        }

        if ($this->prompt_type == 'video') {
            $rules += [
                'meta.max_seconds' => 'required|integer',
                'meta.negative_prompt' => 'nullable|string',
            ];
        }

        return $rules;
    }


    public function attributes()
    {
        return [
            'title' => 'Title',
            'description' => 'Description',
            'preview' => 'Preview Image',
            'icon' => 'Icon',
            'status' => 'Status',
            'prompt' => 'Prompt',
            'prompt_type' => 'Prompt Type',
            'credit_charge' => 'Credit Charge',
            'fields.*.type' => 'Field Type',
            'fields.*.name' => 'Field Name',
            'fields.*.placeholder' => 'Field Placeholder',
            'fields.*.value' => 'Field Value',
            'meta_model' => 'AI Model',
            'meta.max_token' => 'Max Token',
            'meta.max_word' => 'Max Word',
            'meta.image_height' => 'Image Height',
            'meta.image_width' => 'Image Width',
            'meta.guidance_scale' => 'Guidance Scale',
            'meta.steps' => 'Steps',
            'meta.negative_prompt' => 'Negative Prompt',
            'meta.seed' => 'Seed',
            'meta.max_seconds' => 'Max Seconds',
            'meta.voice_id' => 'Voice',
            'meta.decoder_iterations' => 'Voice Quality',
            'meta.aspect_ratio' => 'Aspect Ratio',
            'meta.image_size' => 'Image Size',
            'meta.image_quality' => 'Image Quality',
        ];
    }
}
