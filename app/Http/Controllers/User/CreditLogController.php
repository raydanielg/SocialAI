<?php

namespace App\Http\Controllers\User;

use Inertia\Inertia;
use App\Models\Gateway;
use App\Models\CreditLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AiTemplate;
use App\Models\Brand;
use App\Models\BrandPost;
use App\Models\CreditHistory;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class CreditLogController extends Controller
{
    public function index(Request $request)
    {
        $segments = request()->segments();
        $buttons = [
            [
                'name' => 'Back to Credits',
                'url' => route('user.credits.index')
            ]
        ];
        $creditLogs = CreditLog::query()
            ->where('user_id', auth()->id())
            ->with(['user:id,name,created_at', 'gateway'])
            ->when($request->filled('status'), function ($query) {
                $status = match (request('status')) {
                    'complete' => 1,
                    default => 0,
                };
                $query->where('status', $status);
            })
            ->orderBy('created_at', in_array($request->order, ['desc', 'asc']) ? $request->order : 'desc')
            ->paginate(10);
        $credit_fee = get_option('per_credit_fee');
        $gateways = Gateway::where('status', 1)->select('id', 'name', 'currency', 'logo', 'charge', 'multiply', 'min_amount', 'max_amount', 'is_auto', 'image_accept', 'test_mode', 'status', 'phone_required', 'comment')->get();

        $totalCosts = CreditLog::query()->where('user_id', auth()->id())->sum('price');
        $totalCredits = CreditLog::query()->where('user_id', auth()->id())->sum('credits');

        return Inertia::render('User/Credit/Log', [
            'creditLogs' => $creditLogs,
            'credit_fee' => $credit_fee,
            'gateways' => $gateways,
            'totalCosts' => $totalCosts,
            'totalCredits' => $totalCredits,
            'segments' => $segments,
            'buttons' => $buttons,
        ]);
    }

    public function history(Request $request)
    {
        $segments = request()->segments();
        $buttons = [
            [
                'name' => 'Back to Credits',
                'url' => route('user.credits.index')
            ]
        ];
        $creditHistory = CreditHistory::query()
            ->where('user_id', auth()->id())
            ->with(['creditable'  => function (MorphTo $morphTo) {
                $morphTo->constrain([
                    AiTemplate::class => function ($query) {
                        $query->select('id', 'title');
                    },
                    Brand::class => function ($query) {
                        $query->select('id', 'name');
                    },
                    BrandPost::class => function ($query) {
                        $query->select('id', 'title', 'created_at');
                    },
                ]);
            }])
            ->orderBy('created_at', in_array($request->order, ['desc', 'asc']) ? $request->order : 'desc')
            ->paginate(10);

        $totalCharge = CreditHistory::query()->where('user_id', auth()->id())->sum('charge');
        $total = CreditHistory::query()->where('user_id', auth()->id())->count();
        $totalToday = CreditHistory::query()->where('user_id', auth()->id())
            ->whereDate('created_at', today())->count();

        return Inertia::render('User/Credit/History', [
            'creditHistory' => $creditHistory,
            'totalCharge' => $totalCharge,
            'total' => $total,
            'totalToday' => $totalToday,
            'segments' => $segments,
            'buttons' => $buttons,
        ]);
    }
}
