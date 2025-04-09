<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class EmailVerificationPromptController extends Controller
{
    /**
     * Display the email verification prompt.
     */
    public function __invoke(Request $request): RedirectResponse|Response
    {
        return $request->user()->hasVerifiedEmail() || config('feature.email_verification') == false
                    ? redirect()->intended(route($request->user()->getDashboardRoute()))
                    : Inertia::render('Auth/VerifyEmail', ['status' => session('status'), 'authPages' => get_option('auth_pages', true)]);
    }
}
