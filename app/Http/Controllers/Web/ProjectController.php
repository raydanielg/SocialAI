<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Project;
use App\Helpers\SeoMeta;;

class ProjectController extends Controller
{
    public function index()
    {
        SeoMeta::init('seo_projects');

        return inertia('Web/Projects/Index', [
            'projects' => Project::query()->with('category')->paginate(),
            'categories' => Category::query()->whereType('project')->get(['id', 'title'])
        ]);
    }

    public function show(Project $project)
    {
        $project->load('category');

        SeoMeta::set($project->meta);
        return inertia('Web/Projects/Show', [
            'project' => $project,
            'recentItems' => Project::query()
            ->with('category')
            ->whereNot('id', $project->id)
            ->inRandomOrder()
            ->limit(10)
            ->get(),
        ]);
    }
}
