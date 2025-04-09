<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePlanRequest;
use App\Http\Requests\UpdatePlanRequest;
use Illuminate\Http\Request;
use App\Models\Plan;
use Auth;
use Session;
use Inertia\Inertia;

class PlanController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:subscriptions');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $plans = Plan::latest()->withCount('activeuser')->latest()->get();
        $segments = request()->segments();

        $buttons = [
            [
                'name' => '<i class="bx bx-cog"></i>&nbsp&nbsp' . __('Plan Settings'),
                'url' => '#',
                'target' => '#planSettingDrawer',
            ],
            [
                'name' => '<i class="bx bx-plus mx-2"></i>  &nbsp' . __('Create Plan'),
                'url' => route('admin.plan.create'),
            ]

        ];
        $planSetting = get_option('plan');

        return Inertia::render('Admin/Plan/Index', [
            'plans' => $plans,
            'segments' => $segments,
            'buttons' => $buttons,
            'planSetting' => $planSetting,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $segments = request()->segments();

        $buttons = [
            [
                'name' => __('Plans'),
                'url' => '/admin/plan'
            ],

        ];

        return Inertia::render('Admin/Plan/Create', compact('segments', 'buttons'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePlanRequest $request)
    {
        if(env('DEMO_MODE')){
            return back()->with('danger', __('Permission disabled for demo mode..!'));
        }

        $validated = $request->validated();

        $validated['data'] = $validated['plan_data'];
        unset($validated['plan_data']);

        Plan::create($validated);

        return redirect()->route('admin.plan.index');
    }




    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Plan $plan)
    {
        $segments = request()->segments();

        $buttons = [
            [
                'name' => __('Back'),
                'url' => '/admin/plan'
            ],

        ];

        return Inertia::render('Admin/Plan/Edit', compact('segments', 'buttons', 'plan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePlanRequest $request, Plan $plan)
    {

        if(env('DEMO_MODE')){
            return back()->with('danger', __('Permission disabled for demo mode..!'));
       }

        $validated = $request->validated();

        $validated['data'] = $validated['plan_data'];
        unset($validated['plan_data']);
        $plan->update($validated);

        return redirect()->route('admin.plan.index');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        if(env('DEMO_MODE')){
            return back()->with('danger', __('Permission disabled for demo mode..!'));
        }

        $plan = Plan::withCount('activeuser')->findorFail($id);
        if ($plan->activeuser_count != 0) {
            return back()->with('danger', __('Plan can not be deleted as it has active users!'));
        }
        $plan->delete();

        return back()->with('danger', __('Plan deleted successfully!'));
    }
}
