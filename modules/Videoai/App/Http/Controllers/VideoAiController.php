<?php

namespace Modules\Videoai\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Modules\Videoai\App\Models\AiVideoOption;
use Modules\Videoai\App\Models\PromptPreset;

class VideoAiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function create()
    {
        $provider = 'runwayml';
        $examplePresets = PromptPreset::query()
            ->where('status', 'active')
            ->whereNull('user_id')
            ->get();
        $customPresets = PromptPreset::query()
            ->where('status', 'active')
            ->where('user_id', Auth::id())
            ->get();
        $aiVideoSetting = AiVideoOption::query()
            ->where('provider', $provider)
            ->first();
        $aiVideoConfig = config('videoai.' . $provider . '.' . $aiVideoSetting->version .  '.' . $aiVideoSetting->model);

        return Inertia::render('User/VideoAi/Create', [
            'examplePresets' => $examplePresets,
            'customPresets' => $customPresets,
            'credits' => Auth::user()->credits,
            'aiVideoSetting' => $aiVideoSetting,
            'aiVideoConfig' => $aiVideoConfig
        ]);
    }
}
