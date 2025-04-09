<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePromptRequest extends FormRequest
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
    public function rules()
    {
        $rules = [
            'title' => 'required',
            'status' => 'required',
            'type' => 'required',
            'prompt' => 'required',
            'prompt_type' => 'required',
            'credit_charge' => 'required|numeric|between:0,9999.99',
        ];

        if (!in_array($this->prompt_type, ['image', 'video'])) {
            $rules += [
                'max_token' => 'required|integer',
                'meta.ai_model' => 'required',
                'meta.max_word' => 'required|integer',
            ];
        }
        if ($this->prompt_type == 'image') {
            $rules += [
                'meta.image_ai_model' => 'required|string|in:stablediffusion,stability_ai,dalle_3',
                'meta.negative_prompt' => 'nullable|string',
                'meta.seed' => 'nullable|integer',
            ];
            if ($this->meta['image_ai_model'] === 'stablediffusion') {
                $rules += [
                    'meta.image_height' => 'required|integer|max:1024',
                    'meta.image_width' => 'required|integer|max:1024',
                    'meta.guidance_scale' => 'nullable|numeric',
                ];
            }
            if ($this->meta['image_ai_model'] === 'stability_ai') {
                $rules += [
                    'meta.aspect_ratio' => 'required|string',
                ];
            }
            if ($this->meta['image_ai_model'] === 'dalle_3') {
                $rules += [
                    'meta.image_size' => 'required|string',
                    'meta.image_quality' => 'required|string',
                ];
            }
        }

        if ($this->prompt_type == 'video') {
            $rules += [
                'meta.seconds' => 'required|integer',
            ];
        }

        return $rules;
    }

    public function attributes()
    {
        return [
            'prompt_type' => 'Prompt Type',
            'credit_charge' => 'Credit Charge',
            'meta.ai_model' => 'AI Model',
            'meta.max_token' => 'Max Token',
            'meta.max_word' => 'Max Word',
            'meta.image_height' => 'Image Height',
            'meta.image_width' => 'Image Width',
            'meta.image_size' => 'Image Size',
            'meta.image_quality' => 'Image Quality',
            'meta.aspect_ratio' => 'Aspect Ratio',
            'meta.image_ai_model' => 'Image AI Model',
            'meta.guidance_scale' => 'Guidance Scale',
            'meta.negative_prompt' => 'Negative Prompt',
            'meta.seed' => 'Seed',
            'meta.seconds' => 'Seconds',
        ];
    }
}
