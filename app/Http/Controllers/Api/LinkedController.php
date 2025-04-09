<?php

namespace App\Http\Controllers\Api;

use App\Services\Linkedin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Toastr;

class LinkedController extends Controller
{
    public function redirect()
    {
        $linkedIn = new Linkedin();
        return $linkedIn->authRedirect(config('platform.linkedin.scopes', []));
    }

    public function callback(Request $request)
    {
        $linkedIn = new Linkedin();

        $code = $request->get('code');

        if (!$code) {
            Toastr::danger(__('Failed to get code'));
            return $this->redirectToPlatforms();
        }

        $getAccessTokenRes = $linkedIn->getAccessToken($code);
        $tokenData = $getAccessTokenRes->json();
        $accessToken = $tokenData['access_token'] ?? null;
        $tokenExpireIn = $tokenData['expires_in'] ?? null;

        if ($getAccessTokenRes->failed() || !$accessToken) {
            Toastr::danger(__('Failed to get access token'));
            return $this->redirectToPlatforms();
        }

        $linkedIn->setToken($accessToken);

        $getAccountInfoRes = $linkedIn->getAccountInfo();

        if ($getAccountInfoRes->failed()) {
            Toastr::danger(__('Failed to get account info'));
            return $this->redirectToPlatforms();
        }

        $userData = $getAccountInfoRes->json();

        /**
         * @var \App\Models\User
         */
        $user = auth()->user();
        $user->platforms()->updateOrCreate([
            'platform' => 'linkedin',
            'platform_id' => $userData['sub'],
            'type' => 'user',
        ], [
            'name' => $userData['name'] ?? '',
            'username' => $userData['email'] ?? '',
            'picture' => $userData['picture'],

            'access_token' => $accessToken,
            'access_token_expire_at' => now()->seconds($tokenExpireIn),

            'refresh_token' => $accessToken,
            'refresh_token_expire_at' => now()->seconds($tokenExpireIn),
        ]);

        return $this->redirectToPlatforms();
    }

    public function redirectToPlatforms(): \Illuminate\Http\RedirectResponse
    {
        return to_route('user.platforms.index');
    }
}
