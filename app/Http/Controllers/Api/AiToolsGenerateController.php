<?php

namespace App\Http\Controllers\Api;

use App\Services\AiTool;
use App\Http\Controllers\Controller;
use App\Models\AiTemplate;
use App\Models\Asset;
use App\Models\User;
use App\Services\StabilityAi;
use App\Services\StableDiffusion;
use App\Traits\Uploader;
use Illuminate\Http\Request;
use Auth;

class AiToolsGenerateController extends Controller
{
    use Uploader;
    public function calculateCharge($totalCharge)
    {
        $user = Auth::user();
        if ($totalCharge > $user->credits) {
            return true;
        }
        $user->credits -= $totalCharge;
        $user->save();
        return false;
    }
    public function storeCreditHistory($class, $totalCharge, $description = 'brand', $id = null)
    {
        $user = User::findOrFail(Auth::id());
        $user->creditHistory()->create([
            'creditable_type' => $class,
            'creditable_id' => $id,
            'content_type' => 'text',
            'charge' => $totalCharge ?? 0,
            'description' => 'This record is generated for ' . $description
        ]);
    }
    public function text(Request $request)
    {
        $request->validate([
            'prompt' => 'required|string',
            'language' => 'required|string',
            'tone' => 'required|string',
            'max_token' => 'required|numeric',
            'qty' => 'required|numeric',
            'creativity' => 'required|numeric',
            'fields.*.value' => 'required|string',
        ], [
            'fields.*.value.required' => 'This field is required',
        ]);
        if (env('DEMO_MODE') || env('AI_MOCK_DATA', false)) {
            $text = 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Vel a corporis, quis rem eaque inventore porro vero iusto similique in, reprehenderit libero quidem dicta culpa aspernatur totam praesentium voluptatem temporibus.';
            return $text;
        }
        $template = AiTemplate::findOrFail($request->template_id);

        $maxToken = $template->meta['max_token'];
        if ($request->max_token < $template->meta['max_token']) {
            $maxToken = $request->input('max_token');
        }

        $totalCharge = ($maxToken * $template->credit_charge) * $request->qty;

        $calculateCharge = $this->calculateCharge($totalCharge);
        if ($calculateCharge) {
            return response()->json(['error' => 'Insufficient credits'], 400);
        }

        $prompt = 'Please create content in the language of your choice: ' . $request->language . ' The content should reflect the tone you specified as: ' . $request->tone . ' Your prompt is: ' . $request->prompt . ' Content will be written ' . $request->qty . ' times.';
        $response = AiTool::streamText(
            $template->meta['model'],
            $prompt,
            $request->qty ?? 1,
            $maxToken ?? 100,
            $request->creativity ?? 0.7
        );
        /**
         * @var \App\Models\User
         */
        $user = Auth::user();
        $user->aiGeneratedContents()->create([
            'generatable_type' => AiTemplate::class,
            'generatable_id' => $template->id,
            'content' => implode(' ', $response),
            'result' => $request->qty,
            'length' => $maxToken,
            'charge' => $totalCharge,
            'type' => 'template',
        ]);
        $this->storeCreditHistory(AiTemplate::class, $totalCharge, 'template text', $template->id);
        return response()->json($response);
    }

    public function image(Request $request)
    {
        $request->validate([
            'prompt' => 'required|string',
            'qty' => 'required|numeric',
            'fields.*.value' => 'required|string',
        ], [
            'fields.*.value.required' => 'This field is required',
        ]);
        if (env('DEMO_MODE') || env('AI_MOCK_DATA', false)) {
            $image = url('/assets/images/ai_demo.jpeg');
            Asset::create([
                'user_id' => Auth::id(),
                'path' => $image,
                'type' => 'generated',
                'mime_type' => 'image',
                'file_size' => '1.00',
            ]);
            $images = [];
            for ($i = 0; $i < $request->qty; $i++) {
                $images[] = $image;
            }
            return $images;
        }
        $template = AiTemplate::findOrFail($request->template_id);

        $totalCharge =  $template->credit_charge * $request->qty;

        $calculateCharge = $this->calculateCharge($totalCharge);
        if ($calculateCharge) {
            return response()->json(['error' => 'Insufficient credits'], 400);
        }

        $prompt = 'Your prompt for creating an image is: ' . $request->prompt;
        if ($template->ai_model == 'stability_ai') {
            $ai_model = new StabilityAi($prompt);
            $image = $ai_model->generateImage(
                $prompt,
                $template->meta['seed'] ?? 1,
                $template->meta['negative_prompt'],
                $template->meta['aspect_ratio'],
            );
            $image = [$image];
        } elseif ($template->ai_model == 'dalle_3') {
            $ai_model = new AiTool($prompt);
            $image = $ai_model->generateImage(
                $prompt,
                (int) $request->qty ?? 1,
                $template->meta['image_size'] ?? '1024x1024',
            );
        } else {
            $ai_model = new StableDiffusion($prompt);
            $image = $ai_model->generateImage(
                $prompt,
                $template->meta['image_width'] ?? 512,
                $template->meta['image_height'] ?? 512,
                $request->qty ?? 1,
                $template->meta['guidance_scale'],
                $template->meta['seed'],
                $template->meta['negative_prompt'],

            );
        }
        $this->storeCreditHistory(AiTemplate::class, $totalCharge, 'template image', $template->id);
        return response()->json($image);
    }

    public function fetchVideo()
    {
        $stableDiffusion = new StableDiffusion();

        $video = $stableDiffusion->fetchVideo();
        return response($video);
    }

    public function video(Request $request)
    {
        $request->validate([
            'prompt' => 'required|string',
            'seconds' => 'required|numeric',
            'fields.*.value' => 'required|string',
        ], [
            'fields.*.value.required' => 'This field is required',
        ]);
        $template = AiTemplate::findOrFail($request->template_id);
        $seconds = $template->meta['max_seconds'];
        if ($request->seconds < $template->meta['max_seconds']) {
            $seconds = $request->input('seconds');
        }
        $totalCharge =  $template->credit_charge * $request->seconds;

        $calculateCharge = $this->calculateCharge($totalCharge);
        if ($calculateCharge) {
            return response()->json(['error' => 'Insufficient credits'], 400);
        }

        $prompt = 'Your prompt for creating an video is: ' . $request->prompt;
        $stableDiffusion = new StableDiffusion();
        $response = $stableDiffusion->sendVideoRequest($prompt, $seconds);
        $this->storeCreditHistory(AiTemplate::class, $totalCharge, 'template video', $template->id);
        return response($response);
    }
    public function fetchVoice()
    {
        $stableDiffusion = new StableDiffusion();

        $video = $stableDiffusion->fetchVideo();
        return response($video);
    }

    public function voice(Request $request)
    {
        $request->validate([
            'prompt' => 'required|string',
            'fields.*.value' => 'required|string',
        ], [
            'fields.*.value.required' => 'This field is required',
        ]);
        $template = AiTemplate::findOrFail($request->template_id);

        $totalCharge =  $template->credit_charge * $request->$template->meta['decoder_iterations'];

        $calculateCharge = $this->calculateCharge($totalCharge);
        if ($calculateCharge) {
            return response()->json(['error' => 'Insufficient credits'], 400);
        }

        $prompt = $request->prompt;
        $stableDiffusion = new StableDiffusion();
        $response = $stableDiffusion->sendVoiceRequest($prompt, $template->meta['voice_id'], $template->meta['decoder_iterations']);
        $this->storeCreditHistory(AiTemplate::class, $totalCharge, 'template voice', $template->id);
        return response($response);
    }
    public function audio(Request $request)
    {
        $request->validate([
            'prompt' => 'required|string',
            'init_audio' => 'required|file',
            'fields.*.value' => 'required|string',
        ], [
            'fields.*.value.required' => 'This field is required',
            'init_audio' => 'Audio file',
        ]);

        if ($request->hasFile('init_audio')) {
            $init_audio = $this->saveFile($request, 'init_audio');
        }
        $template = AiTemplate::findOrFail($request->template_id);

        $totalCharge =  $template->credit_charge * $request->$template->meta['decoder_iterations'];

        $calculateCharge = $this->calculateCharge($totalCharge);
        if ($calculateCharge) {
            return response()->json(['error' => 'Insufficient credits'], 400);
        }

        $prompt = $request->prompt;
        $stableDiffusion = new StableDiffusion();
        $response = $stableDiffusion->sendAudioRequest($prompt, $init_audio, $template->meta['decoder_iterations']);
        $this->storeCreditHistory(AiTemplate::class, $totalCharge, 'template audio', $template->id);
        return response($response);
    }
}
