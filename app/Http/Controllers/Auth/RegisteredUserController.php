<?php

namespace App\Http\Controllers\Auth;

use App\Models\Plan;
use App\Models\User;
use Inertia\Inertia;
use App\Helpers\SeoMeta;
use App\Helpers\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterUserRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisteredUserController extends Controller
{
    public function create(Request $request)
    {
        if (isset($request->id)) {
            $plan = Plan::query()->where('status', 1)
                ->where('id', request()->id)->firstOrFail();
            session(['plan_id' => $plan?->id]);
        }

        SeoMeta::init('seo_register');

        $googleClient = !empty(env('GOOGLE_CLIENT_ID')) ? true : false;
        $facebookClient = !empty(env('FACEBOOK_CLIENT_ID')) ? true : false;
        return Inertia::render('Auth/Register', [
            'authPages' => get_option('auth_pages', true),
            'googleClient' => $googleClient,
            'facebookClient' => $facebookClient
        ]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(RegisterUserRequest $request)
    {
        /**
         * @var \App\Models\User $user
         */
        DB::beginTransaction();

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'user',
            ]);

            if (session('plan_id') && $plan = Plan::query()->where('status', 1)->find(session('plan_id'))) {
                $user->plan_data = $plan->data;
                $user->plan_id = $plan->id;
                $user->will_expire = $plan->is_trial == 1 ? now()->addDays($plan->trial_days) : null;
                $user->save();

                Auth::login($user);

                if ($user->will_expire === null) {
                    DB::commit();
                    return Inertia::location(route('user.subscription.payment', $plan->id));
                }
            } else {
                $plan = Plan::query()->where('status', 1)->where('is_default', 1)->first();
                if (!empty($plan)) {
                    $user->plan_data = $plan->data;
                    $user->plan_id = $plan->id;
                    $user->will_expire = now()->addDays($plan->days);
                    $user->save();
                }
            }

            Auth::login($user);

            if (env('EMAIL_VERIFICATION', false)) {
                try {
                    $user->sendEmailVerificationNotification();
                } catch (\Throwable $th) {
                    Toastr::error($th->getMessage() ?? __('Something went wrong while sending verification email'));
                }

                return to_route('verification.notice');
            }
            DB::commit();
            return Inertia::location(route('user.dashboard'));
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('danger', 'An error occurred while registering. Please try again.');
        }
    }
}
