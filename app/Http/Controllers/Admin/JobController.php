<?php

namespace App\Http\Controllers\Admin;

use App\Models\Job;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreJobRequest;
use App\Http\Requests\UpdateJobRequest;

class JobController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:jobs');
    }
    public function index()
    {
        $segments = request()->segments();
        $buttons = [
            [
                'name' => '<i class="fa fa-plus"></i>&nbsp' . __('Add New'),
                'url' => route('admin.jobs.create'),
            ]
        ];

        $jobs = Job::withCount('applications')->paginate();
        $total = Job::count();
        $active = Job::where('is_active', 1)->count();
        $inActive = Job::where('is_active', 0)->count();

        return inertia('Admin/Jobs/Index', [
            'jobs' => $jobs,
            'total' => $total,
            'active' => $active,
            'inActive' => $inActive,
            'buttons' => $buttons,
            'segments' => $segments,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Admin/Jobs/Create', [
            'segments' => request()->segments(),
            'buttons' => [
                [
                    'name' => '<i class="fa fa-list"></i>&nbsp' . __('Back to list'),
                    'url' => route('admin.jobs.index'),
                ]
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreJobRequest $request)
    {

        if(env('DEMO_MODE')){
            return back()->with('danger', __('Permission disabled for demo mode..!'));
       }
        $newJob = $request->validated();
        $newJob['meta'] = $request->input('seo');
        Job::create($newJob);
        return to_route('admin.jobs.index')->with('success', 'Saved Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Job $job)
    {
        return inertia('Admin/Jobs/Applications', [
            'job' => $job,
            'applications' => $job->applications()->paginate(),
            'segments' => request()->segments(),
            'buttons' => [
                [
                    'name' => '<i class="fa fa-list"></i>&nbsp' . __('Back to list'),
                    'url' => route('admin.jobs.index'),
                ]
            ]
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Job $job)
    {
        return inertia('Admin/Jobs/Edit', [
            'job' => $job,
            'segments' => request()->segments(),
            'buttons' => [
                [
                    'name' => '<i class="fa fa-list"></i>&nbsp' . __('Back to list'),
                    'url' => route('admin.jobs.index'),
                ]
            ]
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateJobRequest $request, Job $job)
    {

        if(env('DEMO_MODE')){
            return back()->with('danger', __('Permission disabled for demo mode..!'));
       }
        $newJob = $request->validated();
        $newJob['meta'] = $request->input('seo');

        $job->update($newJob);

        return to_route('admin.jobs.index')->with('info', 'Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Job $job)
    {

        if(env('DEMO_MODE')){
            return back()->with('danger', __('Permission disabled for demo mode..!'));
       }
        $job->delete();
        return to_route('admin.jobs.index')->with('danger', 'Deleted Successfully');
    }
}
