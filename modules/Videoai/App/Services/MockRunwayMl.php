<?php

namespace Modules\Videoai\App\Services;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Modules\Videoai\App\Interface\VideoGeneratorInterface;

class MockRunwayMl implements VideoGeneratorInterface
{
    private const SESSION_COUNTER = 'counter';
    private const SESSION_CREATED_AT = 'created_at';
    private const MAX_SESSION_AGE = 3600;

    public function generateVideo(string $imageUrl, string $prompt, array $options = []): array
    {
        $mockId = Str::uuid()->toString();

        Session::put($this->getSessionKey($mockId, self::SESSION_COUNTER), 0);
        Session::put($this->getSessionKey($mockId, self::SESSION_CREATED_AT), now()->toIso8601String());

        return [
            'success' => true,
            'data' => [
                'id' => $mockId,
                'status' => 'PENDING',
            ],
        ];
    }

    public function getStatus(string $generationId): array
    {
        if (
            !Session::has($this->getSessionKey($generationId, self::SESSION_COUNTER)) ||
            !Session::has($this->getSessionKey($generationId, self::SESSION_CREATED_AT))
        ) {
            return [
                'success' => false,
                'data' => [
                    'status' => 'FAILED',
                    'error' => 'Process not found or expired',
                ],
            ];
        }

        $counterKey = $this->getSessionKey($generationId, self::SESSION_COUNTER);
        $counter = Session::get($counterKey, 0) + 1;
        Session::put($counterKey, $counter);
        $createdAt = Session::get($this->getSessionKey($generationId, self::SESSION_CREATED_AT));

        if ((time() - strtotime($createdAt)) > self::MAX_SESSION_AGE) {
            $this->clearSession($generationId);
            return [
                'success' => false,
                'data' => [
                    'status' => 'FAILED',
                    'error' => 'Process expired',
                ],
            ];
        }

        $status = $this->determineStatus($counter);

        if ($status === 'SUCCEEDED' || $status === 'FAILED') {
            $this->clearSession($generationId);
        }

        return [
            'success' => true,
            'data' => [
                'id' => $generationId,
                'status' => $status,
                'progress' => $status === 'RUNNING' ? 0.5 : null,
                'output' => $status === 'SUCCEEDED' ? [
                    'https://res.cloudinary.com/dyrrxk59h/video/upload/v1732504076/ai_demo_oguagp.mp4'
                ] : null,
            ],
        ];
    }

    public function generateResponse(array $result): JsonResponse
    {
        if (!$result['success']) {
            return response()->json([
                'status' => 'failed',
                'error' => $result['data']['error'] ?? 'Failed to initialize video generation',
            ], 400);
        }

        return response()->json([
            'status' => 'processing',
            'id' => $result['data']['id'],
        ]);
    }

    public function fetchResponse(string $id, array $result, $provider): JsonResponse
    {
        if (!$result['success']) {
            return response()->json([
                'status' => 'failed',
                'error' => $result['data']['error'] ?? 'Failed to fetch video status',
            ], 400);
        }

        $status = $result['data']['status'];
        if (in_array($status, ['PENDING', 'RUNNING'])) {
            return response()->json([
                'data' => [
                    'status' => $status,
                    'id' => $id,
                ],
            ]);
        }

        if ($status === 'SUCCEEDED') {
            return response()->json([
                'data' => [
                    'status' => $status,
                    'output' => $result['data']['output'],
                ],
            ]);
        }

        return response()->json([
            'data' => [
                'status' => 'FAILED',
                'error' => 'Video generation failed',
            ],
        ]);
    }

    private function getSessionKey(string $id, string $type): string
    {
        return "mock_runwayml_{$id}_{$type}";
    }

    private function clearSession(string $id): void
    {
        Session::forget($this->getSessionKey($id, self::SESSION_COUNTER));
        Session::forget($this->getSessionKey($id, self::SESSION_CREATED_AT));
    }

    private function determineStatus(int $counter): string
    {
        return match (true) {
            $counter === 1 => 'PENDING',
            $counter === 2 => 'RUNNING',
            $counter >= 3 => 'SUCCEEDED',
            default => 'FAILED',
        };
    }
}
