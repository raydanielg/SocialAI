<?php

namespace Modules\Videoai\App\Interface;

interface VideoGeneratorInterface
{
    public function generateVideo(string $imageUrl, string $prompt, array $options = []): array;
    public function getStatus(string $generationId): array;
    public function generateResponse(array $result);
    public function fetchResponse(string $id, array $result, $provider);
}
