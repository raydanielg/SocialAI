<?php

namespace App\Http\Controllers\Web;

use App\Models\Job;
use App\Helpers\SeoMeta;
use App\Helpers\Toastr;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rules\File;

class JobController extends Controller
{
    public function index()
    {

        SeoMeta::init('seo_careers');

        return inertia('Web/Jobs/Index', [
            'jobs' => Job::where('is_active', 1)->latest()->get(),
            'career_page' => get_option('career_page', true),
        ]);
    }

    public function show(Job $job)
    {

        SeoMeta::set($job->meta);
        return inertia('Web/Jobs/Show', [
            'job' => $job,
            'jobs' => Job::where('is_active', 1)->latest()->take(5)->get()
        ]);
    }

    public function application(Request $request, Job $job)
    {
        if(env('DEMO_MODE')){
            return back()->with('danger', __('Permission disabled for demo mode..!'));
       }
        // validate if user is not applied yet
        if ($job->applications()->where('email', $request->email)->exists()) {
            Toastr::danger(__('You already applied for this job'));
            return back();
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:30'],
            'email' => ['required', 'email', 'max:50'],
            'phone' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string', 'max:100'],
            'linkedin_profile' => ['required', 'string', 'max:100'],
            'website' => ['nullable', 'string', 'max:50'],
            'experience' => ['required'],
            'expected_salary' => ['required', 'numeric'],
            'note' => ['nullable'],
            'cv' => ['required', File::types(['doc', 'docx', 'pdf'])->max(5000)],
        ]);

        DB::transaction(function () use ($job, $validated) {
            $job->applications()->create($validated);

            Notification::sendToAdmin(
                title: __('Job Application'),
                message: __('New job application submitted'),
                url: url('/admin/jobs/' . $job->slug)
            );
        });

        Toastr::success(__('Application submitted successfully'));

        return back();
    }
}
