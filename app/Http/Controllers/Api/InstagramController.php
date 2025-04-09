<?php

namespace App\Http\Controllers\Api;

use App\Services\Toastr;
use App\Services\Instagram;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InstagramController extends Controller
{

    public function redirect()
    {
        return Instagram::authRedirect([
            'ads_management',
            'business_management',
            'instagram_basic',
            'instagram_content_publish',
            'pages_read_engagement'
        ]);
    }

    public function callback(Request $request)
    {
        $code = $request->get('code');

        if (!$code) {
            Toastr::error('Something went wrong, please try again.');
            return redirect()->route('user.platforms.index');
        }

        $instagram = new Instagram;
        $token = $instagram->getAccessToken($code)->throw()->json('access_token');
        $instagram->setToken($token);

        $pages = $instagram->getAccountInfo(['connected_instagram_account,name,access_token'])
            ->throw()
            ->json('data');

        $connectedPages = [];

        foreach ($pages as $page) {
            if (isset($page['connected_instagram_account'])) {
                array_push($connectedPages, $page);
            }
        }

        /**
         * @var \App\Models\User
         */
        $user = auth()->user();
        foreach ($connectedPages as $insPage) {

            $igAccount = $instagram->getInstagramInfo($insPage['connected_instagram_account']['id'], ['id,name,username,profile_picture_url'])
                ->throw()
                ->json();

            $user->platforms()->updateOrCreate([
                'platform' => 'instagram',
                'platform_id' => $igAccount['id'],
                'type' => 'user',
            ], [
                'name' => $igAccount['name'],
                'username' => $igAccount['username'],
                'picture' => $igAccount['profile_picture_url'],

                'access_token' => $igAccount['access_token'] ?? $token,
                'access_token_expire_at' =>  now()->addMonths(2)
            ]);
        }

        return to_route('user.platforms.index');
    }
}
