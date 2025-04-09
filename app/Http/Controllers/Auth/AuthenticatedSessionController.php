<?php

namespace App\Http\Controllers\Auth;

use Inertia\Inertia;
use Inertia\Response;
use App\Helpers\SeoMeta;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): Response
    {
        SeoMeta::init('seo_login');

        $googleClient = !empty(env('GOOGLE_CLIENT_ID')) ? true : false;
        $facebookClient = !empty(env('FACEBOOK_CLIENT_ID')) ? true : false;


        return Inertia::render('Auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
            'authPages' => get_option('auth_pages', true),
            'googleClient' => $googleClient,
            'facebookClient' => $facebookClient,
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        if (Auth::user()->deleted_at) {
            Auth::logout();
            throw ValidationException::withMessages([
                'email' => trans('This account has been temporary inactive, please contact with admin to get back'),
            ]);
        }

        $request->session()->regenerate();
        if (Auth::user()->role == 'admin') {
            return inertia()->location(route('admin.dashboard'));
        }
        return inertia()->location(route('user.dashboard'));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return inertia()->location('/');
    }
}
