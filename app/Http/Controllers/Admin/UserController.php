<?php

namespace App\Http\Controllers\Admin;

use App\Models\Plan;
use App\Models\User;
use App\Models\Order;
use App\Models\Gateway;
use Illuminate\Support\Str;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Toastr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use Carbon\Carbon;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::query()->with('plan')->where('role', 'user')->paginate();
        $plans = Plan::where('status', 1)->get();
        $gateways = Gateway::where('status', 1)->get();

        $activeUsers = User::where('status', 1)->where('role', 'user')->count();
        $inactiveUsers = User::where('status', 0)->where('role', 'user')->count();
        $totalUsers = User::where('role', 'user')->count();
        return Inertia::render('Admin/Users/Index', [
            'users' => $users,
            'plans' => $plans,
            'gateways' => $gateways,
            'segments' => request()->segments(),
            'activeUsers' => $activeUsers,
            'inactiveUsers' => $inactiveUsers,
            'totalUsers' => $totalUsers
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $totalOrders = $user->orders()->count();
        $totalPendingOrders = $user->orders()->where('status', 2)->count();
        $totalCompleteOrders = $user->orders()->where('status', 1)->count();
        $totalDeclinedOrders = $user->orders()->where('status', 0)->count();

        $orders = $user->orders()->with('user', 'plan', 'gateway')->latest()->paginate(20);

        return Inertia::render('Admin/Users/Show', [
            'showUser' => $user,
            'orders' => $orders,
            'platforms' => $user->platforms()->paginate(),
            'brandPosts' => $user->brandPosts()->paginate(),
            'brands' => $user->brands()->paginate(),
            'assets' => $user->assets()->paginate(),
            'totalOrders' => $totalOrders,
            'totalPendingOrders' => $totalPendingOrders,
            'totalCompleteOrders' => $totalCompleteOrders,
            'totalDeclinedOrders' => $totalDeclinedOrders,
        ]);
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'user_id' => ['required'],
            'plan_id' => ['required', 'exists:plans,id'],
            'gateway_id' => ['nullable', 'exists:gateways,id'],
            'payment_status' => ['nullable'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => [request()->user()->provider_id ? 'nullable' : 'nullable', 'min:6', 'max:255', ],
        ]);

        

       
        if ($request->filled('gateway_id')) {
            $plan = Plan::where('status', 1)->findOrFail($request->plan_id);
            $nextDays = Carbon::now()->addDays((int)$plan->days)->toDateString();
            
            $user->credits = $user->credit + (data_get($plan->data, 'credits.value', 0) + 0);
            $user->plan_id = $plan->id;
            $user->plan_data = $plan->data;
            $user->will_expire = $nextDays;
        }
       
        $user->email = $request->email;

        if ($request->filled('password')) {
             $user->password = bcrypt($request->password);
        }
        $user->save();
         

        if ($request->filled('gateway_id')) {
            $gateway = Gateway::where('status', 1)->findOrFail($request->gateway_id);
           
            
            $tax      = get_option('tax', false);
            $tax      = $tax > 0 ? ($plan->price / 100) * $tax : 0;

            $order = new Order;
            $order->plan_id     = $plan->id;
            $order->payment_id  = Str::random(10);
            $order->user_id     = $user->id;
            $order->gateway_id  = $gateway->id;
            $order->amount      = $plan->price;
            $order->tax         = $tax;
            $order->status      = $request->payment_status;
            $order->will_expire = $nextDays;

            DB::transaction(function () use ($order) {
                $order->save();
                Notification::sendToAdmin(
                    title: __('New plan purchased'),
                    message: __('A User has purchased a plan')
                );
            });
        }



        Session::flash('success', 'User profile information has been successfully updated');

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        Toastr::success('User has been deleted successfully');
        return back();
    }
}
