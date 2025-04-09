<?php

namespace Modules\Videoai\App\Services;

use App\Models\Asset;
use App\Traits\Uploader;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Modules\Videoai\App\Interface\VideoGeneratorInterface;

class RunwayMl implements VideoGeneratorInterface
{
    use Uploader;
    private $client;

    public function __construct(string $apiUrl = null)
    {
        $apiUrl = $apiUrl ?? config('videoai.runwayml.v1.api_url');

        $this->client = Http::withHeaders([
            'Authorization' => 'Bearer ' . config('videoai.runwayml.api_key'),
            'Content-Type' => 'application/json',
            'X-Runway-Version' => '2024-11-06',
        ])->baseUrl($apiUrl);
    }

    public function generateVideo(string $imageUrl, string $prompt, array $options = []): array
    {
        try {
            $response = $this->client->post('/image_to_video', [
                'promptImage' => $imageUrl,
                'seed' => $options['seed'] ?? 4294967295,
                'model' => $options['model'] ?? 'gen3a_turbo',
                'promptText' => $prompt ?? '',
                'watermark' => $options['watermark'] ?? false,
                'duration' => $options['duration'] ?? 5,
                'ratio' => $options['ratio'] ?? '1280:768',
            ]);

            return [
                'success' => $response->successful(),
                'data' => $response->json()
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    public function getStatus(string $generationId): array
    {
        try {
            $response = $this->client->get("/tasks/{$generationId}");
            return [
                'success' => $response->successful(),
                'data' => $response->json()
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    public function generateResponse(array $result): JsonResponse
    {
        if (!$result['success']) {
            return response()->json([
                'status' => 'failed',
                'error' => $result['error'] ?? 'Failed to initialize video generation'
            ], 400);
        }

        // Check if the response has an ID
        $id = $result['data']['id'] ?? null;
        if (!$id) {
            return response()->json([
                'status' => 'failed',
                'error' => 'No generation ID received'
            ], 400);
        }

        return response()->json([
            'status' => 'processing',
            'id' => $id
        ]);
    }

    public function fetchResponse(string $id, array $result, $provider): JsonResponse
    {
        if (!$result['success']) {
            return response()->json([
                'status' => 'failed',
                'error' => $result['error'] ?? 'Failed to fetch video status'
            ], 400);
        }
        $status = $result['data']['status'] ?? 'UNKNOWN';

        if ($status === 'PENDING' || $status === 'RUNNING') {
            return response()->json([
                'status' => $status,
                'id' => $id
            ]);
        }

        if ($status === 'SUCCEEDED') {
            $this->saveVideo($result['data'], $provider);
            return response()->json([
                'status' => $status,
                'output' => $result['data']['output']
            ]);
        }

        if ($status === 'FAILED') {
            $relatedData = Session::get('videoai' . $provider);
            /** @var \App\Models\User */
            $user = Auth::user();
            if (isset($relatedData['totalCharge'])) {
                $user->credits += $relatedData['totalCharge'];
                $user->save();
            }
            Session::forget('videoai' . $provider);
            return response()->json([
                'status' => $status,
                'error' => $result['data']['failure'] ?? 'Video generation failed'
            ]);
        }

        return response()->json([
            'status' => 'FAILED',
            'error' => 'Unknown status received from video service'
        ]);
    }

    public function saveVideo($response, $provider)
    {
        $video = $this->saveFileFromUrl($response['output'][0], '.mp4', '', 'video');
        /** @var \App\Models\User */
        $user = Auth::user();
        $asset = Asset::create([
            'user_id' => $user->id,
            'path' => $video,
            'type' => 'generated',
            'mime_type' => 'video',
            'file_size' => $this->fileSizeInMB($video),
        ]);
        $relatedData = Session::get('videoai' . $provider);
        $user->creditHistory()->create([
            'creditable_type' => Asset::class,
            'creditable_id' => $asset->id,
            'content_type' => 'video',
            'charge' => $relatedData['totalCharge'] ?? 0,
            'description' => 'This record is generated for video'
        ]);
        Session::forget('videoai' . $provider);
        return $response;
    }
}
