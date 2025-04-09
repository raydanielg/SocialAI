<?php
namespace App\Gateway;
use Session;
use Illuminate\Http\Request;
use Inertia\Inertia;

class Stripe {

    public static function redirect_if_payment_success(){
        if(Session::has('call_back')){
            return url(Session::get('call_back')['success']);
        }
    }

    public static function redirect_if_payment_failed(){
        if(Session::has('call_back')){
            return url(Session::get('call_back')['fail']);
        }
    }

    public function view(){

        if(Session::has('stripe_credentials')){
           $Info=Session::get('stripe_credentials');

           return view('gateways.stripe',compact('Info'));
        }
        abort(404);
    }

    public static function fallback()
    {
       return url('/payment/stripe');
    }

    public static function make_payment($array)
    {


        $publishable_key=$array['publishable_key'];
        $secret_key=$array['secret_key'];
        $currency=$array['currency'];
        $email=$array['email'];
        $amount=$array['amount'];
        $totalAmount=$array['pay_amount'];
        $name=$array['name'];
        $billName=$array['billName'];
        $test_mode=$array['test_mode'];
        $data['publishable_key']=$publishable_key;
        $data['secret_key']=$secret_key;
        $data['payment_mode']='stripe';
        $data['amount']=$totalAmount;
        $data['test_mode']=$test_mode;

        $data['charge']=$array['charge'];
        $data['main_amount']=$array['amount'];
        $data['gateway_id']=$array['gateway_id'];
        $data['is_fallback']=$array['is_fallback'] ?? 0;
        $data['payment_type']=$array['payment_type'] ?? '';
        $data['currency']=$array['currency'];






        \Stripe\Stripe::setApiKey($secret_key);


        $logo = get_option('primary_data',true)['logo'] ?? '';


        $lineItems[] = [
            'price_data' => [
                'currency' => 'usd',
                'product_data' => [
                    'name' => $billName,
                    'images' => [asset($logo)]
                ],
                'unit_amount' => $totalAmount * 100,
            ],
            'quantity' => 1,
        ];


        $checkout_data = [
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('stripe.success')."?session_id={CHECKOUT_SESSION_ID}",
            'cancel_url' => route('stripe.fail'),
        ];

        $session = \Stripe\Checkout\Session::create($checkout_data);

        $data['session_id'] = $session->id;
        Session::put('stripe_credentials',$data);

        return Inertia::location($session->url);


    }

    public function status(Request $request)
    {

        abort_if(!Session::has('stripe_credentials'), 404);
        $credentials=Session::get('stripe_credentials');

        \Stripe\Stripe::setApiKey($credentials['secret_key']);
        $sessionId = $request->session_id;
        abort_if($credentials['session_id'] != $sessionId, 404);

        try {
            $session = \Stripe\Checkout\Session::retrieve($sessionId);

            $payment_id = $session->payment_intent;
            $pay_status = $session->payment_status;

            if (!$session || $pay_status != 'paid') {
                $data['payment_status'] = 0;
                Session::put('payment_info',$data);
                Session::forget('stripe_credentials');
                return Inertia::location(Stripe::redirect_if_payment_failed());
            }

            $data['payment_id'] = $payment_id;
            $data['payment_method'] = "stripe";
            $data['gateway_id'] = $credentials['gateway_id'];
            $data['payment_type'] = $credentials['payment_type'];

            $data['amount'] = $credentials['main_amount'];
            $data['charge'] = $credentials['charge'];
            $data['status'] = 1;
            $data['payment_status'] = 1;
            $data['is_fallback'] = $credentials['is_fallback'];
            Session::put('payment_info',$data);
            Session::forget('stripe_credentials');
            return Inertia::location(Stripe::redirect_if_payment_success());


         } catch (\Exception $e) {
            $data['payment_status'] = 0;
            Session::put('payment_info',$data);
            Session::forget('stripe_credentials');
            return Inertia::location(Stripe::redirect_if_payment_failed());
         }


    }


    public function fail(){
        $data['payment_status'] = 0;
        Session::put('payment_info',$data);
        Session::forget('stripe_credentials');
        return Inertia::location(Stripe::redirect_if_payment_failed());
    }

    public static function isfraud($creds){
        $payment_id = $creds['payment_id'];
        $secret_key = $creds['secret_key'];

        try {
        $stripe = new \Stripe\StripeClient($secret_key);

        $response = $stripe->charges->retrieve(
            $payment_id,
            [],
        );
        return $response->status === "succeeded" ? 1 : 0;
        } catch (\Throwable $th) {
            return 0;
        }

    }

}


?>
