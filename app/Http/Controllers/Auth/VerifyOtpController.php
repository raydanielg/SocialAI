<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\Toastr;
use Carbon\Carbon;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VerifyOtpController extends Controller
{
    public function index(Request $request)
    {
        // forget the session if expired
        if (!session('otp_info') || (session('otp_info.expires_at') && Carbon::parse(session('otp_info.expires_at'))->isPast())) {
            session()->forget('otp_info');
            return to_route('phone.verification.index');
        }


        $otpInfo = collect(session('otp_info'))
            ->merge([
                'remaining' => Carbon::parse(session('otp_info.expires_at'))->diffInSeconds(now(), true)
            ])
            ->except(['code'])
            ->toArray();

        return Inertia::render('Auth/VerifyOtp', [
            'status' => 'otp-sent',
            'authPages' => get_option('auth_pages', true),
            'otpInfo' => $otpInfo
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'otp_code' => ['required', 'numeric', 'min_digits:4'],
        ]);

        // check session has otp info and otp is not expired
        if (!session('otp_info') || (session('otp_info.expires_at') && Carbon::parse(session('otp_info.expires_at'))->isPast())) {
            session()->forget('otp_info');
            return to_route('phone.verification.index');
        }

        //   verify the otp code with request otp code
        if ($request->otp_code !== session('otp_info.code')) {
            Toastr::danger(__('The code you entered is incorrect.'));
            return back();
        }

        $request->user()->update([
            'phone' => session('otp_info.phone'),
            'phone_verified_at' => now()
        ]);

        session()->forget('otp_info');

        return inertia_location(route('user.dashboard'));
    }
}
