<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\Toastr;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Services\TwilioService;
use App\Http\Controllers\Controller;
use App\Http\Requests\PhoneVerificationRequest;

class VerifyPhoneController extends Controller
{
    public function index(Request $request)
    {
        if (config('feature.phone_verification') == false || $request->user()->hasVerifiedPhone()) {
            return $this->redirectToUserDashboard();
        }

        if (auth()->user()->phone && $this->otpAlreadySent()) {
            return to_route('otp.verification.index');
        }

        // get the dialers from resource json country list file
        $codes = json_decode(file_get_contents(resource_path('json/country_codes.json')), true);

        $userInfo = [];
        if (auth()->user()->phone) {
            $userInfo = [
                'country_code' => auth()->user()->country_code,
                'phone' => auth()->user()->phone,
            ];
        }

        return Inertia::render('Auth/VerifyPhone', [
            'codes' => $codes,
            'authPages' => get_option('auth_pages', true),
            'userInfo' => $userInfo,
            'status' => session('status'),
        ]);
    }

    public function store(PhoneVerificationRequest $request)
    {
        if (config('feature.phone_verification') == false || $request->user()->hasVerifiedPhone()) {
            return $this->redirectToUserDashboard();
        }

        if ($this->otpAlreadySent()) {
            return to_route('otp.verification.index');
        }

        $request->validate([
            'country_code' => ['required'],
            'phone' => ['required', 'min:9', 'max:14'],
        ]);

        $otpCode = random_int(1000, 9999);
        $message = __('Your verification code is: :otp ', ['otp' => $otpCode]);
        $to = $request->country_code . $request->phone;

        $twilioClient = new TwilioService();
        $sendOtpRes = $twilioClient->sendMessage($to, $message);

        if ($sendOtpRes->failed()) {
            Toastr::danger(__('Something went wrong, please try again.'));
            return back()->with('status', $sendOtpRes->json('message'));
        }

        session()->put('otp_info', [
            'code' => $otpCode,
            'country_code' => $request->country_code,
            'phone' => $request->phone,
            'expires_at' => now()->addMinutes(2),
        ]);

        Toastr::success(__('OTP has been sent successfully, please check your phone.'));
        return to_route('otp.verification.index');
    }

    public function otpAlreadySent(): bool
    {
        return session()->has('otp_info');
    }

    public function redirectToUserDashboard(): \Symfony\Component\HttpFoundation\Response
    {
        /**
         * @var \App\Models\User
         */
        $user = auth()->user();

        session()->forget('otp_info');

        return Inertia::location(route('user.dashboard'));
    }
}
