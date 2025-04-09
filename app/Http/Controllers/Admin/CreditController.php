<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\PageHeader;
use App\Http\Controllers\Controller;
use App\Models\CreditLog;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Cache;
use App\Models\Option;

class CreditController extends Controller
{
    public function index(Request $request)
    {
        PageHeader::set()->title("Credit Logs")->buttons([
            [
                'name' => '<i class="fa fa-credit-card"></i>&nbsp&nbsp' . __('Credit Fee'),
                'url' => '#',
                'target' => '#updateCreditFeeDrawer',

            ]
        ]);
        
        $creditLogs = CreditLog::query();

        if (!empty($request->search)) {
            if ($request->type == 'email') {
                $creditLogs = $creditLogs->whereHas('user', function ($q) {
                    return $q->where('email', request('search'));
                });
            } else {
                $creditLogs = $creditLogs->where($request->type, 'LIKE', '%' . $request->search . '%');
            }
        }
        $creditLogs = $creditLogs
            ->with(['user:id,name,created_at,role', 'gateway'])
            ->paginate(10);

        $totalCreditLog = CreditLog::query()->count();
        $activeCreditLog = CreditLog::query()->where('status', 1)->count();
        $inactiveCreditLog = CreditLog::query()->where('status', 0)->count();
        $per_credit_fee = get_option('per_credit_fee');

        $type = $request->type ?? 'email';
        return Inertia::render('Admin/Credits/Index', [
            'creditLogs' => $creditLogs,
            'per_credit_fee' => $per_credit_fee,
            'totalCreditLog' => $totalCreditLog ?? [],
            'activeCreditLog' => $activeCreditLog ?? [],
            'inactiveCreditLog' => $inactiveCreditLog ?? [],
            'request' => $request,
            'type' => $type,
        ]);
    }

    public function update(Request $request, $id)
    {

        if(env('DEMO_MODE')){
            return back()->with('danger', __('Permission disabled for demo mode..!'));
       }
        $creditLog = CreditLog::findOrFail($id);

        $request->validate([
            'credits' => 'required',
        ]);
        if ($request->status == 1 && $creditLog->status == 0 || $creditLog->status == 2) {
            $user = User::query()->findOrFail($creditLog->user_id);
            $user->increment('credits', $request->credits ?? $creditLog->credits);
        }
        $creditLog->update([
            'credits' => $request->credits,
            'status' => $request->status ?? $creditLog->status,
        ]);

        return back()->with('success', __('Credit log updated successfully'));
    }

    public function updateCreditFee(Request $request)
    {

        if(env('DEMO_MODE')){
            return back()->with('danger', __('Permission disabled for demo mode..!'));
       }
        $option = Option::where('key', 'per_credit_fee')->first();
        $option->value = $request->per_credit_fee;
        $option->save();

        Cache::forget('per_credit_fee');

        return back()->with('success', __('Credit fee updated successfully'));
    }
}
