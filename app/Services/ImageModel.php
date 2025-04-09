<?php

namespace App\Services;

class ImageModel
{
    private $model;

    public function __construct($modelType)
    {
        $this->createAiModel($modelType);
    }

    private function createAiModel($modelType)
    {
        $this->model = match ($modelType) {
            'stability_ai' => new StabilityAi(),
            'dalle_3' => new AiTool(),
            default => new StableDiffusion(),
        };
    }

    public function generateImage($prompt, $meta)
    {
        if ($prompt['image_ai_model'] == 'stability_ai') {
            return $this->model->generateImage($prompt['text'], $meta['seed'], $meta['negative_prompt'], $meta['aspect_ratio']);
        } elseif ($prompt['image_ai_model'] == 'dalle_3') {
            return $this->model->generateImage($prompt['text'], 1, $meta['image_size'] ?? '1024x1024');
        } else {
            return $this->model->generateImage(
                $prompt['text'],
                $meta['image_width'] ?? 512,
                $meta['image_height'] ?? 512,
                1,
                $meta['guidance_scale'],
                $meta['seed'],
                $meta['negative_prompt'],
            );
        }
    }
}
