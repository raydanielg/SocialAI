<?php

namespace App\Services;

use App\Exceptions\SessionException;
use App\Models\Asset;
use App\Models\Brand;
use App\Models\BrandPost;
use App\Models\Prompt;
use App\Models\User;
use App\Traits\Uploader;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BrandAi
{
    use Uploader;
    protected $categories;
    protected $description;
    protected $brand;
    protected $user;

    public function __construct($categories, $description, $brand = null)
    {
        $this->categories = $categories;
        $this->description = $description;
        $this->brand = $brand;

        $this->user = User::findOrFail(Auth::id());
    }
    function removeSpecialChars($text)
    {
        $patterns = '/[\[\]\{\}\(\)""]/';
        return preg_replace($patterns, '', $text);
    }
    public static function aiResponse($prompt, $model = "gpt-3.5-turbo-instruct", $max_tokens = 500)
    {
        return AiTool::text($model, $prompt, 1, $max_tokens);
    }

    public static function mockAiResponse($type)
    {
        $mockData = [
            'voice' => ['Innovative, forward-thinking, customer-focused'],
            'voice-tone' => ['Confident, professional, friendly'],
            'audience' => ['Tech-savvy individuals, IT professionals, businesses seeking IT solutions'],
            'identity' => ['Committed to innovation, Leading the way in IT, Dedicated to customer success'],
            'slogan' => ['Driving Innovation, Powering Success'],
            'post_slogan' => ['Driving Innovation, Powering Success'],
            'strategy' => ['Leverage cutting-edge technology, Deliver unparalleled customer service, Continuously innovate and improve'],
            'post' => ['Lorem ipsum, dolor sit amet consectetur adipisicing elit. Sunt doloribus animi eligendi deleniti consequuntur ipsam, dolor sed fuga fugiat commodi laudantium doloremque deserunt molestias eos, repudiandae harum dignissimos accusantium quidem?'],
        ];

        $data = $mockData[$type] ?? '';

        // mock response
        return $data;
    }

    public function checkCredits()
    {
        $promptTypes = ['voice', 'voice-tone', 'audience', 'identity', 'slogan', 'strategy'];
        $totalCreditCharge = 0;

        $totalCreditCharge = Prompt::query()
            ->whereIn('prompt_type', $promptTypes)
            ->where('status', 'active')
            ->sum('credit_charge');

        if ($this->user->credits < $totalCreditCharge) {
            throw new Exception('You do not have enough credits.');
        }
    }
    public function adjustCredit($creditCharge)
    {
        $user = $this->user;

        if ($user->credits < $creditCharge) {
            throw new SessionException('Insufficient credits. You need at least ' . $creditCharge . ' credits.');
        }

        $user->decrement('credits', $creditCharge);
        $user->save();
    }
    public function brandData()
    {
        // voices
        $voices = $this->brand->voices;
        $message = $voices['message'];
        $tones = array_column($voices['tones'], 'text');
        $tonesString = implode(', ', $tones);
        $voiceMessage = 'message: ' . $message . ' tones: ' . $tonesString;
        // audience
        $audiences = array_column($this->brand->audiences, 'text');
        $audiencesString = implode(', ', $audiences);
        // identity
        $identities = $this->brand->identities;
        $mission = $identities['mission'] ?? '';
        $vision = $identities['vision'] ?? '';
        $values = $identities['values'] ?? '';

        $identityString = "mission: $mission\nvision: $vision\nvalues: $values";
        return [
            'voices' => $voiceMessage ?? '',
            'strategy' => $this->brand?->strategy ?? '',
            'audience' => $audiencesString ?? '',
            'identity' => $identityString ?? '',
            'name' => $this->brand?->name ?? '',
            'description' => $this->brand?->description ?? ''
        ];
    }

    public function storeCreditHistory($class, $totalCharge, $description = 'brand', $id = null)
    {
        $this->user->creditHistory()->create([
            'creditable_type' => $class,
            'creditable_id' => $id ? $id : $class::max('id') + 1,
            'content_type' => 'text',
            'charge' => $totalCharge ?? 0,
            'description' => 'This record is generated for ' . $description
        ]);
    }

    public function storeGeneratedData($class, $contents, $maxToken, $totalCharge, $type = 'brand', $id = null)
    {
        $this->user->aiGeneratedContents()->create([
            'generatable_type' => $class,
            'generatable_id' => $id ? $id : $class::max('id') + 1,
            'content' => $contents,
            'result' => 1,
            'length' => $maxToken ?? 0,
            'charge' => $totalCharge ?? 0,
            'type' => $type,
        ]);
    }

    public function getPrompt($type, $brandData = false)
    {
        $prompt = Prompt::query()
            ->where('status', 'active')
            ->where('prompt_type', $type)
            ->first();
        if (!$prompt) {
            throw new SessionException('No prompt found for ' . $type);
        }

        $categories = implode(", ", $this->categories);

        if ($brandData === true) {
            $brandData = $this->brandData();
            $replacements = [
                '[category]' => $categories,
                '[post_description]' => $this->description,
                '[identity]' => $brandData['identity'],
                '[audience]' => $brandData['audience'],
                '[strategy]' => $brandData['strategy'],
                '[voices]' => $brandData['voices'],
                '[brand_name]' => $brandData['name'],
                '[description]' => $brandData['description'],
            ];
            $promptText = str_replace(array_keys($replacements), array_values($replacements), $prompt->prompt);
        } else {
            $promptText = str_replace(
                ['[category]', '[description]', '[name]'],
                [$categories, $this->description, $this->brand['name']],
                $prompt->prompt
            );
        }

        if (!in_array($prompt->prompt_type, ['image', 'video'])) {
            $maxWordText = 'max ' . ($prompt->meta['max_word'] ?? 0) . ' words.';
            $promptText .= ' ' . $maxWordText;
        }

        return [
            'text' => $promptText,
            'model' => 'gpt-3.5-turbo-instruct',
            'max_tokens' => $prompt->max_token ?? 0,
            'credit_charge' => $prompt->credit_charge,
            'prompt_type' => $prompt->prompt_type,
            'image_ai_model' => $prompt->meta['image_ai_model'] ?? '',
            'meta' => $prompt->meta,
        ];
    }

    public function checkPromptCredit($credit_charge)
    {
        if ($credit_charge > $this->user->credits) {
            return response()->json('Insufficient credits', 400);
        }
    }

    public function promptResponse($type, $extraData = null, $brandData = false)
    {
        $prompt = $this->getPrompt($type, $brandData);

        if (env('DEMO_MODE') && env('AI_MOCK_DATA', false)) {
            $res = $this->mockAiResponse($type);
        } elseif (env('AI_MOCK_DATA', false)) {
            $res = $this->mockAiResponse($type);
        } else {
            $res = $this->aiResponse(
                $prompt['text'] . ($extraData ? ' ' . $extraData : ''),
                $prompt['model'],
                $prompt['max_tokens']
            );
        }
        return [
            'text' => $this->removeSpecialChars($res[0]),
            'credit_charge' => $prompt['credit_charge'],
            'max_tokens' => $prompt['max_tokens'],
        ];
    }

    private function storeData($data, $class, $type = 'brand', $id = null, $subType = null)
    {
        $this->storeGeneratedData(
            $class,
            $data['text'],
            $data['max_tokens'],
            $data['credit_charge'],
            $type,
            $id
        );
        $this->storeCreditHistory($class, $data['credit_charge'], "$type" . ($subType ? " $subType" : ''));
    }

    public function voices()
    {
        $data = ['message' => '', 'tones' => []];
        $voicePrompt = $this->promptResponse('voice');
        $this->adjustCredit($voicePrompt['credit_charge']);
        $data['message'] = $voicePrompt['text'];
        $this->storeData($voicePrompt, Brand::class);

        // voice-tone
        $tonePrompt = $this->getPrompt('voice-tone');
        $this->adjustCredit($tonePrompt['credit_charge']);

        for ($i = 0; $i < 3; $i++) {
            $tone = $this->promptResponse('voice-tone');
            $data['tones'][] = ['text' => $tone['text']];
        }

        $generatedTones = implode(", ", array_column($data['tones'], 'text'));
        $this->storeData(['text' => 'tones: ' . $generatedTones, 'max_tokens' => $tonePrompt['max_tokens'], 'credit_charge' => $tonePrompt['credit_charge']], Brand::class, 'brand');

        return $data;
    }

    public function audiences()
    {
        $prompt = $this->getPrompt('audience');
        $this->adjustCredit($prompt['credit_charge']);

        $data = [];
        for ($i = 0; $i < 3; $i++) {
            $audiences = $this->promptResponse('audience');
            $data[] = ['text' => $audiences['text']];
        }

        $this->storeData(['text' => implode(", ", array_column($data, 'text')), 'max_tokens' => $prompt['max_tokens'], 'credit_charge' => $prompt['credit_charge']], Brand::class);

        return $data;
    }

    public function identities()
    {
        $prompt = $this->getPrompt('identity');
        $this->adjustCredit($prompt['credit_charge']);

        $data = [];
        $keys = ['mission', 'vision', 'values'];
        $generatedIdentity = '';
        foreach ($keys as $key) {
            $identities = $this->promptResponse('identity');

            $data[$key] = $identities['text'];
            $generatedIdentity .= $identities['text'] . ', ';
        }

        $this->storeData(['text' => $generatedIdentity, 'max_tokens' => $prompt['max_tokens'], 'credit_charge' => $prompt['credit_charge']], Brand::class);
        return $data;
    }

    public function slogan()
    {
        $prompt = $this->promptResponse('slogan');
        $this->adjustCredit($prompt['credit_charge']);

        $this->storeData($prompt, Brand::class);
        return $prompt['text'];
    }

    public function strategy()
    {
        $prompt = $this->promptResponse('strategy');
        $this->adjustCredit($prompt['credit_charge']);

        $this->storeData($prompt, Brand::class);
        return $prompt['text'];
    }

    public function posts($platform, $id)
    {
        $end_text = ' for ' . $platform;
        $prompt = $this->promptResponse('post', $end_text, true);
        $this->adjustCredit($prompt['credit_charge']);
        $this->storeData($prompt, BrandPost::class, 'brand_posts', $id, 'post');

        return preg_replace("/[\r\n]+/", "\n", $prompt['text']);
    }

    public function post_slogan($id)
    {
        $prompt = $this->promptResponse('slogan');
        $this->adjustCredit($prompt['credit_charge']);

        $this->storeData($prompt, BrandPost::class, 'brand_posts', $id, 'slogan');

        return $prompt['text'];
    }

    public function image($brandData = false)
    {
        $prompt = $this->getPrompt('image', $brandData);
        if (env('DEMO_MODE') || env('AI_MOCK_DATA', false)) {
            $image = url('/assets/images/ai_demo.jpeg');
            Asset::create([
                'user_id' => Auth::id(),
                'path' => $image,
                'type' => 'generated',
                'mime_type' => 'image',
                'file_size' => $this->fileSizeInMB($image),
            ]);
            return $image;
        }
        $this->checkPromptCredit($prompt['credit_charge']);
        $this->adjustCredit($prompt['credit_charge']);
        $meta = $prompt['meta'];

        $imageModel = new ImageModel($prompt['image_ai_model']);
        $image = $imageModel->generateImage($prompt, $meta);

        $this->storeCreditHistory(Brand::class, $prompt['credit_charge'], 'post image');
        return $image;
    }

    public function video()
    {
        $prompt = $this->getPrompt('video');

        $this->checkPromptCredit($prompt['credit_charge']);
        $this->adjustCredit($prompt['credit_charge']);
        $stableDiffusion = new StableDiffusion();
        $response = $stableDiffusion->sendVideoRequest($prompt['text'], $prompt['meta']['seconds']);
        $this->storeCreditHistory(Brand::class, $prompt['credit_charge'], 'post video');
        return $response;
    }
}
