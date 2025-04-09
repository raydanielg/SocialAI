<?php

namespace Modules\Videoai\App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\Uploader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Modules\Videoai\App\Models\AiVideoOption;
use Modules\Videoai\App\Services\VideoModelFactory;

class VideoAiController extends Controller
{
    use Uploader;

    public function generateVideo(Request $request)
    {
        $validated = $request->validate([
            'prompt' => 'required|string|max:1000',
            'duration' => 'required|integer|min:1|max:10',
            'imageUrl' => 'required|url'
        ]);

        $provider = 'runwayml';
        $aiVideoSetting = AiVideoOption::query()
            ->where('provider', $provider)
            ->first();
        $totalCharge = $validated['duration'] * $aiVideoSetting->meta['credit'];
        /** @var \App\Models\User */
        $user = Auth::user();
        if ($totalCharge > $user->credits) {
            return response()->json(['error' => 'Insufficient credits'], 400);
        }

        $user->credits -= $totalCharge;
        $user->save();


        $options = [
            'duration' => $validated['duration'],
            'watermark' => true,
            'model' => $aiVideoSetting->model
        ];

        $videoGenerator = VideoModelFactory::create($provider);
        $result = $videoGenerator->generateVideo(
            $validated['imageUrl'],
            $validated['prompt'],
            $options
        );

        Session::put('viodeoai' . $provider, array_merge(
            $options,
            [
                'id' => $result['success'] ? $result['data']['id'] : null,
                'totalCharge' => $totalCharge
            ]
        ));
        return $videoGenerator->generateResponse($result);
    }
    public function uploadImage(Request $request)
    {
        try {
            $path = $this->saveFile($request, 'image');
            return response()->json(['status' => 'success', 'path' => $path]);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'failed', 'error' => $th->getMessage()]);
        }
    }
    public function fetchGenerateVideo(string $id, $provider)
    {
        $videoGenerator = VideoModelFactory::create('runwayml');
        $result = $videoGenerator->getStatus($id);

        return $videoGenerator->fetchResponse($id, $result, $provider);
    }
}
