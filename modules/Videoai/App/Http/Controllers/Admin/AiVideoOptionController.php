<?php

namespace Modules\Videoai\App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Traits\Dotenv;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Modules\Videoai\App\Models\AiVideoOption;

class AiVideoOptionController extends Controller
{
    use Dotenv;
    public function index()
    {
        $provider = 'runwayml';
        $RUNWAYML_API_KEY = env('RUNWAYML_API_KEY', '');
        $models = config('videoai.' . $provider . '.v1.models');

        $aiSetting = AiVideoOption::where('provider', $provider)->first();
        return Inertia::render('Admin/Config/Index', [
            'RUNWAYML_API_KEY' => $RUNWAYML_API_KEY,
            'aiSetting' => $aiSetting,
            'models' => $models
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'model' => 'required',
            'meta' => ['required', 'array'],
            'API_KEY' => ['required']
        ]);
        AiVideoOption::updateOrCreate([
            'provider' => 'runwayml',
            'version' => 'v1',
        ], [
            'model' => $request->model,
            'title' => str($request->model)->title(),
            'meta' => $request->meta,
        ]);
        $this->editEnv('RUNWAYML_API_KEY', $request->API_KEY);

        return redirect()->back()->with('success', 'Successfully Added');
    }
}
