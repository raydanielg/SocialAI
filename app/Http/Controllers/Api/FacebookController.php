<?php

namespace App\Http\Controllers\Api;

use App\Services\Facebook;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Toastr;

class FacebookController extends Controller
{

    public function redirect()
    {
        return Facebook::authRedirect([
            'pages_manage_posts',
            'pages_show_list',
            'pages_read_user_content',
            'pages_read_engagement',
            'read_insights'
        ]);
    }

    public function callback(Request $request)
    {
        $fb = new Facebook();
        $code = $request->get('code');

        if (!$code) {
            Toastr::error('Something went wrong, please try again.');
            return redirect()->route('user.platforms.index');
        }

        $token = $fb->getAccessToken($code)->throw()->json('access_token');
        $fb->setToken($token);
        $pages = $fb->getPagesInfo(['name,username,picture,access_token'])->throw()->json('data');

        /**
         * @var \App\Models\User
         */
        $user = auth()->user();

        foreach ($pages as $page) {
            $user->platforms()->updateOrCreate([
                'platform' => 'facebook',
                'platform_id' => $page['id'],
                'type' => 'page',
            ], [
                'name' => data_get($page, 'name'),
                'username' => data_get($page, 'username'),
                'picture' => data_get($page, 'picture.data.url'),

                'access_token' => data_get($page, 'access_token'),
                'access_token_expire_at' =>  config('platform.facebook.access_token_expire_at', now()->addDay()),

                'refresh_token' => data_get($page, 'access_token'),
                'refresh_token_expire_at' => config('platform.facebook.access_token_expire_at', now()->addDay()),
            ]);
        }
        return to_route('user.platforms.index');
    }
}
