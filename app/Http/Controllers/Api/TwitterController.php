<?php

namespace App\Http\Controllers\Api;

use App\Services\Toastr;
use App\Services\Twitter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TwitterController extends Controller
{
    public function redirect()
    {
        $twitter = new Twitter();
        return $twitter->authRedirect();
    }

    public function callback(Request $request)
    {
        $twitter = new Twitter();
        $code = $request->get('code');
        
        if (!$code) {
            Toastr::error('Something went wrong, please try again.');
            return redirect()->route('user.platforms.index');
        }

        $response = $twitter->getAccessToken($code)->throw();
        $this->setPlatformInfo($response->json());
        return to_route('user.platforms.index');
    }

    protected function setPlatformInfo($tokenData)
    {

        $accessToken = $tokenData['access_token'];

        $twitter = new Twitter();
        $twitter->setToken($accessToken);
        $response = $twitter->getUserInfo()->throw();

        $userData = $response->json('data');
        /**
         * @var \App\Models\User
         */
        $user = auth()->user();
        $user->platforms()->updateOrCreate([
            'platform' => 'twitter',
            'platform_id' => $userData['id'],
            'type' => 'user',
        ], [
            'name' => $userData['name'] ?? '',
            'picture' => $userData['profile_image_url'] ?? '',
            'username' => $userData['username'] ?? '',

            'access_token' => $tokenData['access_token'] ?? '',
            'access_token_expire_at' => now()->addMonths(2),

            'refresh_token' => $tokenData['refresh_token'] ?? '',
            'refresh_token_expire_at' => now()->addMonths(2),
        ]);
    }
}
