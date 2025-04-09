<?php

namespace App\Http\Controllers\User;

use App\Models\Plan;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Order;
use App\Models\Gateway;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Toastr;
use App\Traits\Uploader;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class SubscriptionController extends Controller
{
    use Uploader;

    public function index()
    {
        $segments = request()->segments();
        $user = User::with('plan')->findOrFail(auth()->id());
        $plans = Plan::query()
            ->where('price', '>', 0)->where('status', 1)
            ->get();

        $orders = Order::with('plan')->whereUserId(auth()->id())->latest()->paginate();

        $planByDays = $plans->map(function ($plan) {
            return [
                'days' => $plan->days,
                'duration' => $plan->days == 30 ? 'monthly' : ($plan->days == 365 ? 'yearly' : 'lifetime')
            ];
        })->sortBy('days')->unique()->values();
        return Inertia::render('User/Subscription/Index', [
            'user' => $user,
            'plans' => $plans,
            'orders' => $orders,
            'segments' => $segments,
            'planByDays' => $planByDays
        ]);
    }

    public function payment($id)
    {
        $plan = Plan::where('status', 1)->where('price', '>', 0)->where('id', $id)->first();

        if (empty($plan)) {
            Session::flash('saas_error', __('Please select a plan from here'));
            return redirect('/user/subscription');
        }

        if ($plan->price <= 0) {
            Session::flash('saas_error', __('Please select a plan from here'));

            return redirect('/user/subscription');
        }

        $gateways = Gateway::where('status', 1)->select('id', 'name', 'currency', 'logo', 'charge', 'multiply', 'min_amount', 'max_amount', 'is_auto', 'image_accept', 'test_mode', 'status', 'phone_required', 'comment')->get();
        $tax = get_option('tax', true);

        $tax = $tax > 0 ? ($plan->price / 100) * $tax : 0;
        $total = (float) $tax + $plan->price;
        $invoice_data = get_option('invoice_data', true);

        Session::forget('payment_info');
        Session::forget('call_back');
        Session::forget('plan_id');

        $error = Session::has('error');
        $minMax = Session::has('min-max');

        return Inertia::render('User/Subscription/Payment', [
            'plan' => $plan,
            'gateways' => $gateways,
            'tax' => $tax,
            'total' => $total,
            'invoice_data' => $invoice_data,
            'error' => $error,
            'minMax' => $minMax,
            'minMaxMessage' => $minMax ? Session::get('min-max') : '',
            'user' => auth()->user(),
            'logo' => get_option('primary_data', true)['logo'] ?? ''
        ]);
    }

    public function subscribe(Request $request)
    {
        $plan = Plan::where('status', 1)->where('price', '>', 0)->findOrFail($request->plan_id);


        $gateway = Gateway::where('status', 1)->findOrFail($request->gateway_id);
        $tax = get_option('tax', true);
        $tax = $tax > 0 ? ($plan->price / 100) * $tax : 0;
        $total = (float) $tax + $plan->price;
        $payable = $total * $gateway->multiply + $gateway->charge;

        if ($gateway->min_amount > $payable) {
            Session::flash('min-max', __('The minimum transaction amount is ' . $gateway->min_amount));
            return redirect()->back();
        }
        if ($gateway->max_amount != -1) {
            if ($gateway->max_amount < $payable) {
                Session::flash('min-max', __('The maximum transaction amount is ' . $gateway->max_amount));
                return redirect()->back();
            }
        }

        if ($gateway->is_auto == 0) {
            $request->validate([
                'manualPayment.comment' => ['required', 'string', 'max:500'],
                'manualPayment.image' => ['required', 'image', 'max:2048'], // 2MB
            ]);

            $payment_data['comment'] = $request->input('manualPayment.comment');
            $image = $this->saveFile($request, 'manualPayment.image');
            $payment_data['screenshot'] = $image;
            $payment_data['comment'] = $request->input('manualPayment.comment');
        }

        Session::put('plan_id', $plan->id);

        $payment_data['currency'] = $gateway->currency ?? 'USD';
        $payment_data['email'] = Auth::user()->email;
        $payment_data['name'] = Auth::user()->name;
        $payment_data['phone'] = $request->phone;
        $payment_data['billName'] = 'Plan Name: ' . $plan->title;
        $payment_data['amount'] = $total;
        $payment_data['test_mode'] = $gateway->test_mode;
        $payment_data['charge'] = $gateway->charge ?? 0;
        $payment_data['pay_amount'] = str_replace(',', '', number_format($payable));
        $payment_data['gateway_id'] = $gateway->id;
        $callback['success'] = url('user/subscription/plan/success');
        $callback['fail'] = url('user/subscription/plan/failed');
        $callback['coingate_webhook_route'] = 'coingate.order.callback';
        Session::put('call_back', $callback);

        if (!empty($gateway->data)) {
            foreach (json_decode($gateway->data ?? '') ?? [] as $key => $info) {
                $payment_data[$key] = $info;
            };
        }

        return $gateway->namespace::make_payment($payment_data);
    }

    public function status($status)
    {

        abort_if(!Session::has('call_back') || !Session::has('plan_id'), 404);

        return $status == 'success' ? $this->success() : $this->failed();
    }

    public function success()
    {
        $redirectUrl = '/user/subscription';
        $paymentInfo = Session::get('payment_info');
        $plan = Plan::where('status', 1)->where('price', '>', 0)->find(Session::get('plan_id'));

        if (!$paymentInfo || !$plan) {
            Toastr::error(__('Something went wrong while processing payment!'));
            return redirect($redirectUrl);
        }


        /**
         * @var \App\Models\User
         */
        $user = auth()->user();

        $isNewUser = $user->will_expire === null;

        DB::beginTransaction();
        if ($paymentInfo['status'] == 1) {
            $user->plan_data = $plan->data;
            $user->credits = $user->credits + $plan->data['credits']['value'] ?? 0;
            $user->plan_id = $plan->id;
            $user->will_expire = now()->addDays($plan->days);
            $user->save();
        }

        $tax = get_option('tax', true);
        $tax = $tax > 0 ? ($plan->price / 100) * $tax : 0;

        $order = new Order;
        $order->plan_id = $plan->id;
        $order->payment_id = $paymentInfo['payment_id'];
        $order->user_id = Auth::id();
        $order->gateway_id = $paymentInfo['gateway_id'];
        $order->amount = $paymentInfo['amount'];
        $order->tax = $tax;
        $order->status = $paymentInfo['status'];
        $order->will_expire = now()->addDays($plan->days);
        if (isset($paymentInfo['meta'])) {
            $order->meta = json_encode($paymentInfo['meta']);
        }
        $order->save();
        Notification::sendToAdmin(__('New plan purchased'), __('A User has purchased a plan'));

        DB::commit();

        Session::forget(['payment_info', 'call_back', 'plan_id']);

        $message = $paymentInfo['status'] == 1 ? __('Your subscription payment is complete') : __('Your subscription payment is complete admin will review this payment manually for approval.');
        Toastr::success($message);

        if ($paymentInfo['status'] === 1 && $isNewUser) {
            return redirect(route('user.brand.create'));
        }

        return redirect($redirectUrl);
    }

    public function failed()
    {
        $plan_id = Session::get('plan_id');
        Session::forget(['payment_info', 'call_back', 'plan_id']);
        Session::flash('error', true);

        return redirect('/user/subscription/payment/' . $plan_id);
    }
}
