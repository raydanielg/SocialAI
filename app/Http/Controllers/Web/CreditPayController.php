<?php

namespace App\Http\Controllers\Web;

use App\Models\User;
use App\Models\Gateway;
use App\Models\CreditLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Traits\Uploader;

class CreditPayController extends Controller
{
    use Uploader;


    public function store(Request $request)
    {
        if (empty($request->gateway_id)) {
            return back()->withErrors([
                'gateway_id' => __('Please select a payment gateway'),
            ])->onlyInput('gateway_id');
        }


        $gateway  = Gateway::where('status', 1)->findOrFail($request->gateway_id);

        $credit_fee = get_option('per_credit_fee');
        $total    = $request->credits / $credit_fee;

        $orderData['payable'] = $total * $gateway->multiply + $gateway->charge;
        $orderData['orders'] = [
            'user_id' => Auth::user()->id,
            'credits' => $request->credits,
            'total' => $request->total,
            'status' => 0,
        ];



        Session::put('order_credit_data', $orderData);
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

        $payment_data['currency']   = $gateway->currency ?? 'USD';
        $payment_data['email']      = Auth::user()->email;
        $payment_data['name']       = Auth::user()->name;
        $payment_data['phone']      = $request->phone;
        $payment_data['billName']   = 'Order from - ' . env('APP_NAME');
        $payment_data['amount']     = $total;
        $payment_data['test_mode']  = $gateway->test_mode;
        $payment_data['charge']     = $gateway->charge ?? 0;
        $payment_data['pay_amount'] =  str_replace(',', '', number_format($orderData['payable']));
        $payment_data['gateway_id']  = $gateway->id;

        $callback['success'] = url('/credit/pay/success');
        $callback['fail']    = url('/credit/pay/failed');
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

        abort_if(!Session::has('call_back') || !Session::has('order_credit_data'), 404);
        return $status == 'success' ? $this->success() : $this->failed();
    }


    public function success()
    {
        abort_if(!Session::has('payment_info'), 404);


        $paymentInfo = Session::get('payment_info');

        Session::forget('payment_info');
        Session::forget('call_back');


        $orderData     = Session::get('order_credit_data');
        abort_if($paymentInfo['amount'] != $orderData['orders']['total'], 404);

        $order = new CreditLog();
        $order->user_id     = Auth::user()->id;
        $order->payment_id  = $paymentInfo['payment_id'];
        $order->gateway_id  = $paymentInfo['gateway_id'];
        $order->price       = $paymentInfo['amount'];
        $order->credits     = $orderData['orders']['credits'];
        $order->status      = $paymentInfo['payment_status'] ?? 0;

        if (isset($paymentInfo['meta'])) {
            $order->meta    = json_encode($paymentInfo['meta']);
        }
        $order->save();

        if ($order->status == 1) {
            $user = User::query()->findOrFail(Auth::user()->id);
            $user->increment('credits', $orderData['orders']['credits']);
        }
        Session::forget('order_credit_data');
        return redirect('/user/credit-logs');
    }

    public function failed()
    {

        Session::forget('payment_info');
        Session::forget('call_back');
        Session::forget('order_credit_data');

        return redirect('/user/credit-logs')->withErrors([
            'gateway_id' => __('Oops! We encountered an issue processing your payment. Please check your payment details and retry.'),
        ])->onlyInput('gateway_id');
    }
}