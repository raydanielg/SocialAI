<?php

namespace App\Gateway;

use Inertia\Inertia;
use App\Models\Gateway;
use App\Models\PaymentLog;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class Coingate
{
    public static string $token;

    public function __construct()
    {
        $gateway = Gateway::find(12);
        $token = json_decode($gateway->data, true)['access_token'];

        // trow if token not found
        if (empty($token)) {
            throw new \Exception('Coingate token not found!');
        }

        self::setToken($token);
    }

    public static function getBaseApiUrl(): string
    {
        return 'https://api-sandbox.coingate.com/v2';
    }

    public static function getCallbackUrl(string $uuid)
    {
        return url("/coingate/{$uuid}/callback");
    }

    public static function setToken(string $token)
    {
        self::$token = $token;
    }

    public static function callApi(string $method = 'get', string $endpoint, array $data = []): \Illuminate\Http\Client\Response
    {
        return Http::asForm()->withHeaders([
                    'Authorization' => 'Token ' . self::$token
                ])->$method(self::getBaseApiUrl() . $endpoint, $data);
    }

    public static function get(string $endpoint, array $data = []): \Illuminate\Http\Client\Response
    {
        return self::callApi('get', $endpoint, $data);
    }

    public static function post(string $endpoint, array $data = []): \Illuminate\Http\Client\Response
    {
        return self::callApi('post', $endpoint, $data);
    }

    /**
     * Create a new coingate payment
     *
     * @param array $data
     *
     * @return \Inertia\Response
     *
     * @throws \Exception
     */
    public static function make_payment(array $data)
    {
        // validate access token
        if (!isset($data['access_token'])) {
            throw new \Exception('Access Token is required for coingate payment gateway'); // throws exception if token not found
        }

        self::setToken($data['access_token']); // set token

        Session::put('gateway_id', $data['gateway_id']); // set current gateway id

        $orderId = uniqid('order-'); // generate a unique order id
        Session::put('order_uid', $orderId); // set order id

        $sessionCallback = session('call_back'); // get callback route

        $successUrl = route('coingate.success'); // get success url
        $failUrl = route('coingate.failed'); // get fail url

        if (!isset($sessionCallback['coingate_webhook_route'])) {
            throw new \Exception('Coingate webhook route not found');
        }

        $callbackUrl = route($sessionCallback['coingate_webhook_route'], $orderId); // get callback url

        $gateway = Gateway::findOrFail(session('gateway_id')); // get current gateway

        $res = self::post('/orders', [ // send request
            'title' => $data['billName'] ?? 'Payment',
            'price_amount' => $data['pay_amount'],
            'price_currency' => $gateway->currency,
            'receive_currency' => $data['currency'],
            'callback_url' => $callbackUrl,
            'success_url' => $successUrl,
            'cancel_url' => $failUrl,
            'order_id' => $orderId,
            'description' => $data['billName'],
        ]);

        if ($res->failed()) { // check if request failed
            throw new \Exception($res->json('message') ?? __('Something went wrong!')); // throw exception if failed
        }

        if ($res->successful()) { // check if request was successful
            Session::put('order_id', $res->json('id')); // set order id

            return Inertia::location($res->json('payment_url')); // return payment url
        }
    }




    public function success()
    {
        $orderId = session('order_id');
        $res = self::get("/orders/$orderId");

        if ($res->json('status') == 'paid') {
            $gateway = Gateway::findOrFail(session('gateway_id'));
            $payment_info = [
                'payment_id' => $res->json('id'),
                'payment_method' => $gateway->name,
                'gateway_id' => $gateway->id,
                'payment_type' => 'auto',
                'amount' => $res->json('price_amount'),
                'charge' => $gateway->charge,
                'status' => 'pending',
                'payment_status' => 2,
                'is_fallback' => false,
            ];

            if ($gateway->log_enabled) {
                PaymentLog::query()->create([
                    'user_id' => auth()->check() ? auth()->id() : null,
                    'gateway_id' => $gateway->id,
                    'order_id' => $res->json('id'),
                    'order_uuid' => $res->json('order_id'),
                    'price_currency' => $res->json('price_currency', 0),
                    'price_amount' => $res->json('price_amount', 0),
                    'pay_currency' => $res->json('pay_currency', 0),
                    'pay_amount' => $res->json('pay_amount', 0),
                    'receive_currency' => $res->json('receive_currency', 0),
                    'receive_amount' => $res->json('receive_amount', 0),
                    'conversion_rate' => $res->json('conversion_rate', 0),
                    'payment_status' => $res->json('status', 'unpaid'),
                ]);
            }

            Session::put('payment_info', $payment_info);
            Session::put('order_id', $res->json('id'));
            return Inertia::location(session('call_back.success'));
        }
    }

    public function failed()
    {
        Session::forget(['order_id', 'order_uuid']);
        return Inertia::location(session('call_back.failed', '/'));
    }
}
