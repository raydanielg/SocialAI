<?php

namespace App\Services;

use App\Models\Asset;
use App\Traits\Uploader;
use OpenAI;

class AiTool
{
    use Uploader;
    private $prompt;
    public function __construct($prompt = null)
    {
        $this->prompt = $prompt;
    }
    private static function generateCompletions($model, $prompt, $qty, $max_tokens, $temperature = 0.2, $stream = false)
    {
        $client = OpenAI::client(config('openai.api_key'));
        $params = [
            'model' => $model,
            'prompt' => $prompt,
            'n' => (int) $qty,
            'max_tokens' => (int) $max_tokens,
            'temperature' => (float) $temperature,
            'logprobs' => 0
        ];

        if ($stream) {
            $response = $client->completions()->createStreamed($params);
            $textData = [];
            foreach ($response as $stream) {
                $textData[] = $stream->choices[0]->text;
            }
            return $textData;
        }

        $response = $client->completions()->create($params);
        return array_map(function ($choice) {
            return $choice->text;
        }, $response->choices);
    }

    private static function generateChatCompletions($model, $prompt, $qty, $max_tokens, $temperature = 0.2, $stream = false)
    {
        $client = OpenAI::client(config('openai.api_key'));
        $params = [
            'model' => $model,
            'messages' => [
                ['role' => 'user', 'content' => $prompt]
            ],
            'n' => (int) $qty,
            'max_tokens' => (int) $max_tokens,
            'temperature' => (float) $temperature,
            'logprobs' => 0
        ];

        if ($stream) {
            $response = $client->chat()->createStreamed($params);
            $textData = [];
            foreach ($response as $stream) {
                $textData[] = $stream->choices[0]->delta->content;
            }
            return $textData;
        }

        $response = $client->chat()->create($params);
        return array_map(function ($choice) {
            return $choice->message->content;
        }, $response->choices);
    }

    private static function generateText($model, $prompt, $qty, $max_tokens, $temperature = 0.2, $stream = false)
    {
        if (in_array($model, config('openai.chat_models'))) {
            return self::generateChatCompletions($model, $prompt, $qty, $max_tokens, $temperature, $stream);
        } else {
            return self::generateCompletions($model, $prompt, $qty, $max_tokens, $temperature, $stream);
        }
    }

    public static function streamText($model, $prompt, $qty, $max_tokens, $temperature)
    {
        return self::generateText($model, $prompt, $qty, $max_tokens, $temperature, true);
    }

    public static function text($model, $prompt, $qty, $max_tokens, $temperature = 0.2)
    {
        return self::generateText($model, $prompt, $qty, $max_tokens, $temperature);
    }


    public function generateImage($prompt, $qty = 1, $size)
    {
        $client = OpenAI::client(config('openai.api_key'));
        $response = $client->images()->create([
            'model' => 'dall-e-3',
            'prompt' => $this->prompt ?? $prompt,
            'n' => $qty ?? 1,
            'size' => $size ?? '1024x1024',
            'response_format' => 'url',
        ]);
        if ($response?->data && $response->created) {
            return $this->saveImage($response);
        }
        return response()->json($response);
    }

    private function saveImage($response)
    {
        $images = [];

        foreach ($response->data as $data) {
            $url = $data->url;
            $image = $this->saveFileFromUrl($url);
            Asset::create([
                'user_id' => auth()->id(),
                'path' => $image,
                'type' => 'generated',
                'mime_type' => 'image',
                'file_size' => $this->fileSizeInMB($image),
            ]);
            $images[] = $image;
        }

        return $images;
    }
}
