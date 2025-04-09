<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class CronjobController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:cron-job');
    }

    public function index()
    {

        if(env('DEMO_MODE')){
            return back()->with('danger', __('Permission disabled for demo mode..!'));
       }

        $jobs = [
            [
                'title' => __('Execute Schedule Messages'),
                'url' => 'curl -s ' . url('/cron/execute-schedule'),
                'time' => __('Everyday')
            ],
            [
                'title' => __('Notify to customer before expire the subscription'),
                'url' => 'curl -s ' . url('/cron/notify-to-user'),
                'time' => __('Everyday at once')
            ],
            [
                'title' => __('Check Social Media Connected Status'),
                'url' => 'curl -s ' . url('/cron/refresh-platform-tokens'),
                'time' => __('Everyday at once')
            ],
            [
                'title' => __('Execute Schedule Posts'),
                'url' => 'curl -s ' . url('/cron/dispatch-schedule-posts'),
                'time' => __('Every 1 minute')
            ],
            
            [
                'title' => __('Cleanup Temporary Post Data Files'),
                'url' => 'curl -s ' . url('/cleanup-temp-post-data-files'),
                'time' => __('Everyday at once')
            ]
        ];

        return Inertia::render('Admin/Cron/Index', compact('jobs'));
    }


}
