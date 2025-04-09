<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use App\Helpers\PlanPerks;
use App\Services\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class SaasMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        /**
         * @var \App\Models\User
         */
        $user = $request->user();

        if (!$user->plan_data) {
            return back()->with("danger", __("You haven't purchased any subscription plans yet."));
        }

        if ($user->will_expire == null) {
            Toastr::setToast('danger', __('Your subscription payment is not completed'));
            $redirect_url = $user->plan_id == null ? '/user/subscription' : '/user/subscription/payment/' . $user->plan_id;
            return inertia()->location($redirect_url);
        }

        if ($user->will_expire < now()) {
            Toastr::setToast('danger', __('Your subscription payment was expired please renew the subscription'));
            return redirect('/user/dashboard');
        }

        if ($request->is('oauth/redirect/*')) {
            $user->validatePlan('social_accounts');
            return $next($request);
        }

        if (
            $request->is('user/subscription*')
            || $request->is('user/make-subscribe/*')
        ) {
            return $next($request);
        }

        return $next($request);
    }
}
