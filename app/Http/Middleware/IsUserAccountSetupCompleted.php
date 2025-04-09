<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsUserAccountSetupCompleted
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // redirect if user is admin
        if ($request->user()->role == 'admin') {
            return $next($request);
        }

        if (!$request->user()->setLocation()) {
            return to_route('account.setup');
        }

        if (config('feature.phone_verification') && !$request->user()->hasVerifiedPhone()) {
            return to_route('phone.verification.index');
        }

        if (config('feature.email_verification') && !$request->user()->hasVerifiedEmail()) {
            return to_route('verification.notice');
        }

        if (!$request->is('user/kyc*') && config('feature.kyc_verification') && !$request->user()->hasVerifiedKYC()) {
            return to_route('user.kyc.index');
        }
        return $next($request);
    }
}
