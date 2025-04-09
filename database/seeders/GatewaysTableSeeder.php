<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Gateway;

class GatewaysTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $gateways = array(
            array('id' => '1', 'name' => 'paypal', 'currency' => 'usd', 'logo' => '/demo/paypal.png', 'charge' => '2', 'multiply' => '1', 'namespace' => 'App\\Gateway\\Paypal', 'min_amount' => '1', 'max_amount' => '1000', 'is_auto' => '1', 'image_accept' => '0', 'test_mode' => '1', 'status' => '0', 'phone_required' => '0', 'log_enabled' => '0', 'data' => '{"client_id":"","client_secret":""}', 'comment' => NULL, 'created_at' => '2024-04-03 03:44:01', 'updated_at' => '2024-04-03 03:44:01'),
            array('id' => '2', 'name' => 'stripe', 'currency' => 'usd', 'logo' => '/demo/stripe.png', 'charge' => '2', 'multiply' => '1', 'namespace' => 'App\\Gateway\\Stripe', 'min_amount' => '1', 'max_amount' => '1000', 'is_auto' => '1', 'image_accept' => '0', 'test_mode' => '1', 'status' => '0', 'phone_required' => '0', 'log_enabled' => '0', 'data' => '{"publishable_key":"","secret_key":""}', 'comment' => NULL, 'created_at' => '2024-04-03 03:44:01', 'updated_at' => '2024-04-03 03:44:01'),
            array('id' => '3', 'name' => 'mollie', 'currency' => 'usd', 'logo' => '/demo/mollie.png', 'charge' => '2', 'multiply' => '1', 'namespace' => 'App\\Gateway\\Mollie', 'min_amount' => '1', 'max_amount' => '1000', 'is_auto' => '1', 'image_accept' => '0', 'test_mode' => '1', 'status' => '1', 'phone_required' => '0', 'log_enabled' => '0', 'data' => '{"api_key":"test_WqUGsP9qywy3eRVvWMRayxmVB5dx2r"}', 'comment' => NULL, 'created_at' => '2024-04-03 03:44:01', 'updated_at' => '2024-04-03 03:44:01'),
            array('id' => '4', 'name' => 'paystack', 'currency' => NULL, 'logo' => '/demo/paystack.png', 'charge' => '2', 'multiply' => '1', 'namespace' => 'App\\Gateway\\Paystack', 'min_amount' => '1', 'max_amount' => '1000', 'is_auto' => '1', 'image_accept' => '0', 'test_mode' => '1', 'status' => '0', 'phone_required' => '0', 'log_enabled' => '0', 'data' => '{"public_key":"","secret_key":""}', 'comment' => NULL, 'created_at' => '2024-04-03 03:44:01', 'updated_at' => '2024-04-03 03:44:01'),
            array('id' => '5', 'name' => 'razorpay', 'currency' => 'inr', 'logo' => '/demo/rajorpay.png', 'charge' => '2', 'multiply' => '1', 'namespace' => 'App\\Gateway\\Razorpay', 'min_amount' => '1', 'max_amount' => '10000', 'is_auto' => '1', 'image_accept' => '0', 'test_mode' => '1', 'status' => '0', 'phone_required' => '0', 'log_enabled' => '0', 'data' => '{"key_id":"","key_secret":""}', 'comment' => NULL, 'created_at' => '2024-04-03 03:44:01', 'updated_at' => '2024-04-03 03:44:01'),
            array('id' => '6', 'name' => 'instamojo', 'currency' => 'inr', 'logo' => '/demo/instamojo.png', 'charge' => '2', 'multiply' => '1', 'namespace' => 'App\\Gateway\\Instamojo', 'min_amount' => '1', 'max_amount' => '1000', 'is_auto' => '1', 'image_accept' => '0', 'test_mode' => '1', 'status' => '0', 'phone_required' => '1', 'log_enabled' => '0', 'data' => '{"x_api_key":"","x_auth_token":""}', 'comment' => NULL, 'created_at' => '2024-04-03 03:44:01', 'updated_at' => '2024-04-03 03:44:01'),
            array('id' => '7', 'name' => 'toyyibpay', 'currency' => 'rm', 'logo' => '/demo/toyybipay.png', 'charge' => '2', 'multiply' => '1', 'namespace' => 'App\\Gateway\\Toyyibpay', 'min_amount' => '1', 'max_amount' => '1000', 'is_auto' => '1', 'image_accept' => '0', 'test_mode' => '1', 'status' => '0', 'phone_required' => '1', 'log_enabled' => '0', 'data' => '{"user_secret_key":"","cateogry_code":""}', 'comment' => NULL, 'created_at' => '2024-04-03 03:44:01', 'updated_at' => '2024-04-03 03:44:01'),
            array('id' => '8', 'name' => 'flutterwave', 'currency' => NULL, 'logo' => '/demo/flutterwave.png', 'charge' => '2', 'multiply' => '1', 'namespace' => 'App\\Gateway\\Flutterwave', 'min_amount' => '1', 'max_amount' => '1000', 'is_auto' => '1', 'image_accept' => '0', 'test_mode' => '1', 'status' => '0', 'phone_required' => '1', 'log_enabled' => '0', 'data' => '{"public_key":"","secret_key":"","encryption_key":"","payment_options":"card"}', 'comment' => NULL, 'created_at' => '2024-04-03 03:44:01', 'updated_at' => '2024-04-03 03:44:01'),
            array('id' => '9', 'name' => 'payu', 'currency' => NULL, 'logo' => '/demo/payu.png', 'charge' => '2', 'multiply' => '1', 'namespace' => 'App\\Gateway\\Payu', 'min_amount' => '1', 'max_amount' => '1000', 'is_auto' => '1', 'image_accept' => '0', 'test_mode' => '1', 'status' => '0', 'phone_required' => '1', 'log_enabled' => '0', 'data' => '{"merchant_key":"","merchant_salt":"","auth_header":""}', 'comment' => NULL, 'created_at' => '2024-04-03 03:44:01', 'updated_at' => '2024-04-03 03:44:01'),
            array('id' => '10', 'name' => 'thawani', 'currency' => NULL, 'logo' => '/demo/uhawan.png', 'charge' => '1', 'multiply' => '1', 'namespace' => 'App\\Gateway\\Thawani', 'min_amount' => '1', 'max_amount' => '1000', 'is_auto' => '1', 'image_accept' => '0', 'test_mode' => '1', 'status' => '0', 'phone_required' => '1', 'log_enabled' => '0', 'data' => '{"secret_key":"","publishable_key":""}', 'comment' => NULL, 'created_at' => '2024-04-03 03:44:01', 'updated_at' => '2024-04-03 03:44:01'),
            array('id' => '11', 'name' => 'mercadopago', 'currency' => NULL, 'logo' => '/demo/mercado-pago.png', 'charge' => '2', 'multiply' => '1', 'namespace' => 'App\\Gateway\\Mercado', 'min_amount' => '1', 'max_amount' => '1000', 'is_auto' => '1', 'image_accept' => '0', 'test_mode' => '1', 'status' => '0', 'phone_required' => '0', 'log_enabled' => '0', 'data' => '{"secret_key":"","public_key":""}', 'comment' => NULL, 'created_at' => '2024-04-03 03:44:01', 'updated_at' => '2024-04-03 03:44:01'),
            array('id' => '12', 'name' => 'Coingate', 'currency' => 'USD', 'logo' => '/demo/coingate-logo.png', 'charge' => '2', 'multiply' => '1', 'namespace' => 'App\\Gateway\\Coingate', 'min_amount' => '1', 'max_amount' => '1000', 'is_auto' => '1', 'image_accept' => '0', 'test_mode' => '1', 'status' => '1', 'phone_required' => '0', 'log_enabled' => '1', 'data' => '{"access_token":"HEkexnMqTUKNVxFp1Cug_3auLEmMWq6iZ_kSA-s5","price_currency":"USD","receive_currency":"DO_NOT_CONVERT"}', 'comment' => 'abc', 'created_at' => '2024-04-03 03:44:01', 'updated_at' => '2024-04-03 03:59:49')
        );

        Gateway::insert($gateways);
    }
}
