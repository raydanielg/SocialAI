<?php

namespace App\Http\Controllers\User;

use Inertia\Inertia;
use App\Models\Gateway;
use App\Traits\Uploader;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Models\AiGenerate;

class CreditController extends Controller
{
    use Uploader;
    public function index()
    {
        $segments = request()->segments();
        $buttons = [
            [
                'name' => 'Credit Logs',
                'url' => route('user.credit-logs.index')
            ],
            [
                'name' => 'Credit History',
                'url' => route('user.credit-logs.history')
            ],

        ];
        /**
         * @var \App\Models\User
         */
        $user = auth()->user();

        $credits = $user->credits ?? 0;

        $activeChartFilterBtn = request('scope') ?? 'day';

        $dateFormat = match (request('scope')) {
            'year' => "%Y",
            'month' => "%M %Y",
            'week' => "%a",
            default => "%h:%i %p",
        };

        $costChartData = AiGenerate::query()
            ->where('user_id', auth()->id())
            ->selectRaw("DATE_FORMAT(ai_generates.created_at,'$dateFormat') as date, SUM(ai_generates.charge) as credit")

            ->when($activeChartFilterBtn == 'day', function ($query) {
                return $query->whereDate('created_at', today())
                    ->groupByRaw('HOUR(ai_generates.created_at)');
            })
            ->when($activeChartFilterBtn == 'week', function ($query) {
                $start = now()->startOfWeek(Carbon::SATURDAY);
                $end = now()->endOfWeek(Carbon::FRIDAY);
                return  $query->whereBetween('created_at', [$start, $end])
                    ->groupByRaw('DAY(ai_generates.created_at)');
            })
            ->when($activeChartFilterBtn == 'month', function ($query) {
                $year = today()->year;
                return  $query->whereYear('created_at', $year)->groupByRaw('MONTH(ai_generates.created_at)');
            })
            ->when($activeChartFilterBtn == 'year', function ($query) {

                return  $query->groupByRaw('YEAR(ai_generates.created_at)');
            })
            ->get();

        $totalCostAmount = (int) $costChartData->sum('credit');

        $spendCreditAmount = (int) AiGenerate::query()
            ->where('user_id', auth()->id())
            ->whereMonth('created_at', now()->month)->groupByRaw('MONTH(ai_generates.created_at)')
            ->sum('charge');

        $availableCreditAmount = (int) auth()->user()->credits ?? 0;
        $total = $spendCreditAmount + $availableCreditAmount * 100;

        $credit_fee = get_option('per_credit_fee');
        $gateways = Gateway::where('status', 1)->select('id', 'name', 'currency', 'logo', 'charge', 'multiply', 'min_amount', 'max_amount', 'is_auto', 'image_accept', 'test_mode', 'status', 'phone_required', 'comment')->get();

        return Inertia::render('User/Credit/Index', compact(
            'segments',
            'buttons',
            'credits',
            'costChartData',
            'activeChartFilterBtn',
            'credit_fee',
            'gateways',
            'totalCostAmount',
            'availableCreditAmount',
            'spendCreditAmount',
        ));
    }
}
