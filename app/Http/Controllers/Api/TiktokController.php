<?php

namespace App\Http\Controllers\Api;

use App\Services\Tiktok;
use App\Services\Toastr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TiktokController extends Controller
{
    protected $api;

    public function __construct()
    {
        $this->api = new Tiktok();
    }

    public function redirect()
    {
        return $this->api->authRedirect();
    }

    public function callback(Request $request)
    {
        $code = $request->get('code');

        if (!$code) {
            Toastr::error('Something went wrong, please try again.');
            return redirect()->route('user.platforms.index');
        }

        $response = $this->api->getAccessToken($code)
            ->throw();

        if ($response->json('error')) {
           echo $response->status();
           die();
        }

        $tokenData = $response->object();

        /**
         * @var \App\Models\User
         */
        $user = auth()->user();

        $user->platforms()->updateOrCreate([
            'platform' => 'tiktok',
            'platform_id' => $tokenData->open_id,
            'type' => 'user',
        ], [
            'access_token' => $tokenData->access_token ?? '',
            'access_token_expire_at' => now()->addSeconds($tokenData->expires_in ?? 0),

            'refresh_token' => $tokenData->refresh_token ?? '',
            'refresh_token_expire_at' => now()->addSeconds($tokenData->refresh_expires_in ?? 0),
        ]);

        $this->api->setToken($tokenData->access_token);
        $this->setProfileInfo();

        return to_route('user.platforms.index');
    }

    protected function setProfileInfo()
    {
        $userData = $this->api->getAccountInfo([
            'open_id'
        ])
            ->throw()
            ->json('data.user');

        $creatorInfoData = $this->api->getCreatorInfo();

        $creatorInfo = [];

        if (isset($creatorInfoData['error']['code']) && $creatorInfoData['error']['code'] === 'ok') {
            $creatorInfo = $creatorInfoData['data'] ?? [];
        }

        /**
         * @var \App\Models\User
         */
        $user = auth()->user();

        $user->platforms()->updateOrCreate([
            'platform' => 'tiktok',
            'platform_id' => $userData['open_id'],
            'type' => 'user',
        ], [
            'name' => $creatorInfo['creator_nickname'] ?? '',
            'username' => $creatorInfo['creator_username'] ?? '',
            'picture' => $creatorInfo['creator_avatar_url'] ?? '',
            'meta' => $creatorInfo ?? [],
        ]);
    }
}
