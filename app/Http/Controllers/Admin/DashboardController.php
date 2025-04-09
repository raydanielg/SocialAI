<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Plan;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Asset;
use App\Models\Brand;
use App\Models\Order;
use App\Models\BrandPost;
use App\Models\CreditLog;
use App\Models\AiGenerate;
use App\Models\UserPlatform;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $totalOrders = Order::count();
        $totalSales = Order::sum('amount');
        $popularPlans = Plan::whereHas('orders')
            ->withCount('activeuser')
            ->withCount('orders')
            ->orderByDesc('orders_count')
            ->withSum('orders', 'amount')
            ->get()
            ->map(function ($query) {
                return [
                    'name'          => $query->title,
                    'activeuser'    => number_format($query->activeuser_count),
                    'orders_count'  => number_format($query->orders_count),
                    'total_amount'  => amount_format($query->orders_sum_amount, 'icon'),
                ];
            });

        $mostOrderedPlans = Plan::query()
            ->select('id', 'title', 'price', 'days')
            ->where('status', 1)
            ->when($request->plan === 'today', function ($query) {
                $query->whereHas('orders', function ($q) {
                    $q->whereDate('created_at', Carbon::today());
                });
            })
            ->when($request->plan === 'month', function ($query) {
                $query->whereHas('orders', function ($q) {
                    $q->whereYear('created_at', Carbon::now()->year)
                        ->whereMonth('created_at', Carbon::now()->month);
                });
            })
            ->has('orders')
            ->withCount('orders')
            ->orderByDesc('orders_count')
            ->limit(4)
            ->get();

        $recentOrders = Order::whereHas('user')
            ->whereHas('plan')
            ->with('user:id,avatar,name,created_at', 'plan:id,title')
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($query) {
                return [
                    'avatar'      => $query->user->avatar ? asset($query->user->avatar) : 'https://ui-avatars.com/api/?name=' . $query->user->name,
                    'name'        => $query->user->name,
                    'plan'        => $query->plan->title,
                    'invoice'     => $query->invoice_no,
                    'amount'      => amount_format($query->amount, 'icon'),
                    'created_at'  => $query->created_at->diffForHumans(),
                    'link'        => url('admin/order/' . $query->id),
                ];
            });

        // chart
        $filterBy = request('sales') ?? 'day';
        $dateFormat = match ($filterBy) {
            'year' => "%Y",
            'month' => "%M %Y",
            'week' => "%a",
            default => "%h",
        };
        $salesOverview = Order::query()
            ->selectRaw("DATE_FORMAT(orders.created_at,'$dateFormat') as date, SUM(orders.amount) as sales")
            ->when($filterBy == 'day', function ($query) {
                $query->whereDate('created_at', today())
                    ->groupByRaw('HOUR(orders.created_at)');
            })
            ->when($filterBy == 'week', function ($query) {
                $start = now()->startOfWeek(Carbon::SATURDAY);
                $end = now()->endOfWeek(Carbon::FRIDAY);
                $query->whereBetween('orders.created_at', [$start, $end])
                    ->groupByRaw('DAY(orders.created_at)');
            })
            ->when($filterBy == 'month', function ($query) {
                $query->whereYear('created_at', now()->year)
                    ->groupByRaw('MONTH(orders.created_at)');
            })
            ->when($filterBy == 'year', function ($query) {
                $query->groupByRaw('YEAR(orders.created_at)');
            })
            ->orderBy('orders.created_at', 'asc')
            ->get()->map(function ($query) {
                return [
                    'date' => $query->date,
                    'sales' => round($query->sales, 2),
                ];
            });
        $recentPosts = BrandPost::query()->with(['brand:id,name', 'user:id,name'])
            ->latest()->take(6)->get();
        $recentCreditLogs = CreditLog::query()
            ->with(['user:id,name,created_at,role', 'gateway'])
            ->take(6)->get();
        $totalBrands = Brand::query()
            ->count();
        $totalPosts = BrandPost::query()
            ->count();
        // likes,comment,storage,credits,social_accounts
        //get todays orders

        $recentOrders = Order::query()
            ->whereDate('created_at', today())
            ->count();

        $totalCustomers = User::where('role', 'user')->count();

        $totalStorage = Asset::query()
            ->sum('file_size');
        $socialAccounts = UserPlatform::query()
            ->count();
        $totalCredits = AiGenerate::query()
            ->sum('charge');
        return Inertia::render('Admin/Dashboard', [
            'totalOrders' => $totalOrders,
            'totalSales' => amount_format($totalSales, ''),
            'mostOrderedPlans' => $mostOrderedPlans,
            'popularPlans' => $popularPlans,
            'recentOrders' => $recentOrders,
            'recentPosts' => $recentPosts,
            'recentCreditLogs' => $recentCreditLogs,
            'salesOverview' => $salesOverview,
            'totalBrands' =>  $totalBrands,
            'totalPosts' => $totalPosts,
            'recentOrders' => $recentOrders,
            'totalCustomers' => $totalCustomers,
            'totalStorage' => $totalStorage,
            'socialAccounts' => $socialAccounts,
            'totalCredits' => $totalCredits,
            'request' => $request,
        ]);
    }
}
