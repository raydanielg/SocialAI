<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\AiTemplate;
use App\Models\User;
use Inertia\Inertia;

class AiToolsController extends Controller
{
    public function index()
    {
        $segments = request()->segments();
        $user = User::query()->findOrFail(auth()->id());
        $templates = AiTemplate::query()
            ->withCount(['users as isBookmarked' => function ($query) {
                $query->where('user_id', auth()->id());
            }])
            ->latest()
            ->orderBy('isBookmarked', 'DESC')
            ->get();
        return Inertia::render('User/AiTools/Index', [
            'templates' => $templates,
            'credits' => auth()->user()->credits,
            'bookmarked' => $user->aiTemplates()->select('ai_templates.id')->get(),
            'segments' => $segments,
        ]);
    }
    public function show($uuid)
    {
        $template = AiTemplate::where('uuid', $uuid)->firstOrFail();
        $languages = json_decode(file_get_contents(base_path('database/json/languages.json')), true);
        $languages = array_values(array_map(function ($language) {
            return [
                'id'   => $language['id'],
                'name' => $language['name'],
            ];
        }, $languages));

        return Inertia::render('User/AiTools/Show', [
            'template' => $template,
            'credits' => auth()->user()->credits,
            'languages' => $languages
        ]);
    }

    public function bookmark()
    {
        $user = User::query()->findOrFail(auth()->id());

        $user->aiTemplates()->toggle(request('ai_template_id'));
        return back();
    }
}
