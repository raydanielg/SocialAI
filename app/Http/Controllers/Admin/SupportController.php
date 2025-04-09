<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Support;
use App\Models\Supportlog;
use Auth;
use Inertia\Inertia;

class SupportController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:support');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $segments = request()->segments();
        $buttons = [];
        $supports = Support::query();
        if (!empty($request->search)) {
            if ($request->type == 'email') {
                $supports = $supports->whereHas('user', function ($q) use ($request) {
                    return $q->where('email', $request->search);
                });
            } else {
                $supports = $supports->where($request->type, 'LIKE', '%' . $request->search . '%');
            }
        }
        $supports = $supports->with('user')->withCount('conversations')->latest()->paginate(20);

        $pendingSupport = Support::where('status', 2)->count();
        $openSupport = Support::where('status', 1)->count();
        $closedSupport = Support::where('status', 0)->count();
        $totalSupports = $pendingSupport + $openSupport + $closedSupport;

        $type = $request->type ?? 'email';
        $invoice = get_option('invoice_data', true);
        $currency = get_option('base_currency', true);
        $tax = get_option('tax');
        return Inertia::render('Admin/Support/Index', [
            'request' => $request,
            'supports' => $supports,
            'pendingSupport' => $pendingSupport,
            'openSupport' => $openSupport,
            'closedSupport' => $closedSupport,
            'totalSupports' => $totalSupports,
            'type' => $type,
            'segments' => $segments,
            'buttons' => $buttons,
            'invoice' => $invoice,
            'currency' => $currency,
            'tax' => $tax
        ]);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $segments = request()->segments();
        $buttons = [
            [
                'name' => __('Back'),
                'url' => route('admin.support.index'),
            ]
        ];
        $support = Support::with('conversations.user', 'user')->findOrFail($id);
        Supportlog::where('is_admin', 0)->where('support_id', $id)->update([
            'seen' => 1
        ]);

        return Inertia::render('Admin/Support/Show', [
            'support' => $support,
            'segments' => $segments,
            'buttons' => $buttons,
        ]);
    }


    public function update(Request $request, $id)
    {

        if(env('DEMO_MODE')){
            return back()->with('danger', __('Permission disabled for demo mode..!'));
       }
        $support = Support::findOrFail($id);


        $support->status = $request->status;
        $support->save();
        if ($request->filled('message')) {
            $request->validate([
                'message' => 'required|max:1000',
            ]);
            $support->conversations()->create([
                'comment'  => $request->message,
                'is_admin' => 1,
                'seen' => 0,
                'user_id'  => Auth::id()
            ]);
        }

        return back();
    }
}
