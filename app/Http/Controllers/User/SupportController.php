<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Support;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SupportController extends Controller
{
    public function index(Request $request)
    {
        $segments = request()->segments();
        $buttons = [
            [
                'name' => '<i class="fa fa-plus"></i>&nbsp' . __('Add New'),
                'url' => route('user.supports.create'),
            ]
        ];

        $supports = Support::where('user_id', auth()->id())
            ->withCount('conversations')
            ->orderBy('created_at', $request->order ?? 'desc')->paginate(20);

        $totalSupports = Support::where('user_id', auth()->id())
            ->count();
        $pendingSupport = Support::where('user_id', auth()->id())
            ->where('status', 2)
            ->count();
        $openSupport = Support::where('user_id', auth()->id())
            ->where('status', 1)
            ->count();
        $closedSupport = Support::where('user_id', auth()->id())
            ->where('status', 0)
            ->count();
        return Inertia::render('User/Support/Index', [
            'supports' => $supports,
            'buttons' => $buttons,
            'totalSupports' => $totalSupports,
            'pendingSupport' => $pendingSupport,
            'openSupport' => $openSupport,
            'closedSupport' => $closedSupport,
        ]);
    }

    public function create()
    {
        $buttons = [
            [
                'name' => '<i class="fa fa-plus"></i>&nbsp' . __('Add New'),
                'url' => route('user.supports.create'),
            ]
        ];
        return Inertia::render('User/Support/Create', [
            'buttons' => $buttons,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|max:100|min:10',
            'message' => 'required|max:1000',
        ]);

        $support = new Support;
        $support->user_id = auth()->id();
        $support->subject = $request->subject;
        $support->save();

        $support->conversations()->create([
            'comment'  => $request->message,
            'is_admin' => 0,
            'user_id'  => auth()->id()
        ]);

        return to_route('user.supports.index');
    }

    public function show(string $id)
    {
        $support = Support::where('user_id', auth()->id())
            ->with(['conversations.user', 'user'])->findOrFail($id);

        return Inertia::render('User/Support/Show', [
            'support' => $support,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'message' => 'required|max:1000',
        ]);

        $support = Support::where('user_id', auth()->id())->where('status', 1)->findOrFail($id);

        $support->conversations()->create([
            'comment'  => $request->message,
            'is_admin' => 0,
            'seen' => 0,
            'user_id'  => auth()->id()
        ]);

        return back();
    }
}
