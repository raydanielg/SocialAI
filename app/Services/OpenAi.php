<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class OpenAi
{

    private ?string $apiKey = null;
    private ?string $apiUrl = null;
    private ?array $data = [];

    public function __construct(array $data = [], string $apiKey = null, string $apiUrl = null)
    {
        $this->data = $data;
        $this->apiKey($apiKey);
        $this->apiUrl($apiUrl);
    }

    public static function make(?array $data = [])
    {
        return new self($data);
    }

    // creator methods
    public function completions(?array $data = [])
    {
        if ($data) {
            $this->$data = $data;
        }
        return $this;
    }

    // modifiers

    public function apiKey(?string $key)
    {
        $this->apiKey = $key ?? env('OPENAI_API_KEY');
        return $this;
    }

    public function apiUrl(?string $url)
    {
        $this->apiUrl = $url ?? 'https://api.openai.com/v1/completions';
        return $this;
    }

    public function data(array $data)
    {
        $this->data = $data;
        return $this;
    }

    public function model(?string $model)
    {
        $this->data['model'] = $model;
        return $this;
    }

    public function prompt(?string $prompt)
    {
        $this->data['prompt'] = $prompt;
        return $this;
    }

    public function n(?string $n)
    {
        $this->data['n'] = $n;
        return $this;
    }

    public function maxToken(int $maxToken = 100)
    {
        $this->data['maxToken'] = $maxToken;
        return $this;
    }

    public function temperature(float $temperature = 0.7)
    {
        $this->data['temperature'] = $temperature;
        return $this;
    }

    public function streamed($stream = true)
    {
        $this->data['stream'] = $stream;
        return $this;
    }

    public function getResponse()
    {
        return Http::withToken($this->apiKey)
            ->acceptJson()
            ->post($this->apiUrl, $this->data);
    }

    // aliases
    public function get()
    {
        return $this->getResponse();
    }


    // utility methods
    public function dd()
    {
        return dd($this);
    }

    public function __toString()
    {
        $ins = self::make(self::$data);
        return $ins->getResponse();
    }
}
