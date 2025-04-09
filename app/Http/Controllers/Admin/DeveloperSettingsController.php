<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Toastr;
use DateTimeZone;
use Inertia\Inertia;
use App\Traits\Dotenv;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use File;
class DeveloperSettingsController extends Controller
{
    use Dotenv;

    public function __construct()
    {
        $this->middleware('permission:developer-settings');
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $segments = request()->segments();

        $buttons = [
            [
                'name' => __('Back to dashboard'),
                'url' => url('/admin/dashboard')
            ],
        ];

        if ($id == 'app-settings') {
            $tzlist = DateTimeZone::listIdentifiers(DateTimeZone::ALL);
            $languages = get_option('languages', false);
            $appName = env('APP_NAME');
            $web_visibility = env('WEB_VISIBILITY', true);
            $appDebug = env('APP_DEBUG');
            $timeZone = env('TIME_ZONE', 'UTC');
            $default_lang = env('DEFAULT_LANG', 'en');

            return Inertia::render('Admin/Developer/App', compact('id', 'tzlist', 'languages','web_visibility', 'appName', 'appDebug', 'timeZone', 'default_lang', 'segments', 'buttons'));
        }
        elseif ($id == 'newsletter-settings') {

            $NEWSLETTER_API_KEY = env('NEWSLETTER_API_KEY');
            $NEWSLETTER_LIST_ID = env('NEWSLETTER_LIST_ID');

            return Inertia::render(
                'Admin/Developer/Newsletter',
                compact(
                    'id',
                    'NEWSLETTER_API_KEY',
                    'NEWSLETTER_LIST_ID',
                    'segments',
                    'buttons'
                )
            );
        } 
        elseif ($id == 'mail-settings') {
            $mailDriver = env('MAIL_DRIVER_TYPE') == 'MAIL_DRIVER' ? env('MAIL_DRIVER') : env('MAIL_MAILER');
            $QUEUE_MAIL = env('QUEUE_MAIL');
            $MAIL_DRIVER_TYPE = env('MAIL_DRIVER_TYPE');
            $MAIL_HOST = env('MAIL_HOST');
            $MAIL_PORT = env('MAIL_PORT');
            $MAIL_USERNAME = env('MAIL_USERNAME');
            $MAIL_PASSWORD = env('MAIL_PASSWORD');
            $MAIL_ENCRYPTION = env('MAIL_ENCRYPTION');
            $MAIL_FROM_ADDRESS = env('MAIL_FROM_ADDRESS');
            $MAIL_FROM_NAME = env('MAIL_FROM_NAME');
            $MAIL_TO = env('MAIL_TO');

            return Inertia::render(
                'Admin/Developer/Smtp',
                compact(
                    'id',
                    'mailDriver',
                    'segments',
                    'buttons',
                    'QUEUE_MAIL',
                    'MAIL_DRIVER_TYPE',
                    'MAIL_HOST',
                    'MAIL_PORT',
                    'MAIL_USERNAME',
                    'MAIL_PASSWORD',
                    'MAIL_ENCRYPTION',
                    'MAIL_FROM_ADDRESS',
                    'MAIL_FROM_NAME',
                    'MAIL_TO',
                )
            );
        } elseif ($id == 'storage-settings') {
            $FILESYSTEM_DISK = env('FILESYSTEM_DISK');
            $WAS_ACCESS_KEY_ID = env('WAS_ACCESS_KEY_ID');
            $SECRET_ACCESS_KEY = env('SECRET_ACCESS_KEY');
            $WAS_DEFAULT_REGION = env('WAS_DEFAULT_REGION');
            $WAS_BUCKET = env('WAS_BUCKET');
            $WAS_ENDPOINT = env('WAS_ENDPOINT');

            return Inertia::render(
                'Admin/Developer/Storage',
                compact(
                    'id',
                    'FILESYSTEM_DISK',
                    'WAS_ACCESS_KEY_ID',
                    'SECRET_ACCESS_KEY',
                    'WAS_DEFAULT_REGION',
                    'WAS_BUCKET',
                    'WAS_ENDPOINT',
                    'segments',
                    'buttons'
                )
            );
        } elseif ($id == 'platform-settings') {

            $FACEBOOK_APP_ID = env('FACEBOOK_APP_ID');
            $FACEBOOK_APP_SECRET = env('FACEBOOK_APP_SECRET');
            $FACEBOOK_REDIRECT_URI = route('callback.facebook');

            $INSTAGRAM_APP_ID = env('INSTAGRAM_APP_ID');
            $INSTAGRAM_APP_SECRET = env('INSTAGRAM_APP_SECRET');
            $INSTAGRAM_REDIRECT_URI = route('callback.instagram');

            $TWITTER_API_KEY = env('TWITTER_API_KEY');
            $TWITTER_API_KEY_SECRET = env('TWITTER_API_KEY_SECRET');
            $TWITTER_ACCESS_TOKEN = env('TWITTER_ACCESS_TOKEN');
            $TWITTER_ACCESS_TOKEN_SECRET = env('TWITTER_ACCESS_TOKEN_SECRET');
            $TWITTER_CLIENT_ID = env('TWITTER_CLIENT_ID');
            $TWITTER_CLIENT_SECRET = env('TWITTER_CLIENT_SECRET');
            $TWITTER_REDIRECT_URI = route('callback.twitter');

            $LINKEDIN_APP_ID = env('LINKEDIN_APP_ID');
            $LINKEDIN_APP_SECRET = env('LINKEDIN_APP_SECRET');
            $LINKEDIN_REDIRECT_URI = route('callback.linkedin');

            $TIKTOK_APP_ID = env('TIKTOK_APP_ID');
            $TIKTOK_APP_KEY = env('TIKTOK_APP_KEY');
            $TIKTOK_APP_SECRET = env('TIKTOK_APP_SECRET');
            $TIKTOK_REDIRECT_URI = route('callback.tiktok');

            return Inertia::render(
                'Admin/Developer/Platform',
                compact(
                    'id',
                    'segments',
                    'buttons',
                    'FACEBOOK_APP_ID',
                    'FACEBOOK_APP_SECRET',
                    'FACEBOOK_REDIRECT_URI',

                    'INSTAGRAM_APP_ID',
                    'INSTAGRAM_APP_SECRET',
                    'INSTAGRAM_REDIRECT_URI',

                    'TWITTER_API_KEY',
                    'TWITTER_API_KEY_SECRET',
                    'TWITTER_ACCESS_TOKEN',
                    'TWITTER_ACCESS_TOKEN_SECRET',
                    'TWITTER_CLIENT_ID',
                    'TWITTER_CLIENT_SECRET',
                    'TWITTER_REDIRECT_URI',

                    'LINKEDIN_APP_ID',
                    'LINKEDIN_APP_SECRET',
                    'LINKEDIN_REDIRECT_URI',

                    'TIKTOK_APP_ID',
                    'TIKTOK_APP_KEY',
                    'TIKTOK_APP_SECRET',
                    'TIKTOK_REDIRECT_URI',
                )
            );
        } elseif ($id == 'ai-api-settings') {
            $STABLE_DIFFUSION_API_MODE = env('STABLE_DIFFUSION_API_MODE', 'stage');
            $STABLE_DIFFUSION_API_KEY = env('STABLE_DIFFUSION_API_KEY');
            $STABILITY_AI_API_KEY = env('STABILITY_AI_API_KEY');
            $OPENAI_API_KEY = env('OPENAI_API_KEY');
            $AI_MOCK_DATA = env('AI_MOCK_DATA');

            return Inertia::render(
                'Admin/Developer/AiApi',
                compact(
                    'id',
                    'STABLE_DIFFUSION_API_MODE',
                    'STABLE_DIFFUSION_API_KEY',
                    'STABILITY_AI_API_KEY',
                    'OPENAI_API_KEY',
                    'AI_MOCK_DATA',
                    'segments',
                    'buttons'
                )
            );
        } elseif ($id == 'cookie-settings') {

            $COOKIE_CONSENT = env('COOKIE_CONSENT');
            $cookieData = json_decode(file_get_contents(database_path('json/cookie_data.json')), true);
            return Inertia::render(
                'Admin/Developer/Cookie',
                compact(
                    'id',
                    'COOKIE_CONSENT',
                    'cookieData',
                    'segments',
                    'buttons'
                )
            );
        } elseif ($id == 'social-login-settings') {

            $GOOGLE_CLIENT_ID = env('GOOGLE_CLIENT_ID');
            $GOOGLE_CLIENT_SECRET = env('GOOGLE_CLIENT_SECRET');
            $GOOGLE_REDIRECT_URL = env('GOOGLE_REDIRECT_URL');

            $FACEBOOK_APP_ID = env('FACEBOOK_CLIENT_ID');
            $FACEBOOK_APP_SECRET = env('FACEBOOK_CLIENT_SECRET');
            $FACEBOOK_REDIRECT_URI = env('FACEBOOK_REDIRECT_URL');

            return Inertia::render(
                'Admin/Developer/SocialLogin',
                compact(
                    'id',
                    'GOOGLE_CLIENT_ID',
                    'GOOGLE_CLIENT_SECRET',
                    'GOOGLE_REDIRECT_URL',
                    'FACEBOOK_APP_ID',
                    'FACEBOOK_APP_SECRET',
                    'FACEBOOK_REDIRECT_URI',
                    'segments',
                    'buttons'
                )
            );
        } elseif ($id == 'stock-media-settings') {
            $UNSPLASH_API_KEY = env('UNSPLASH_API_KEY');
            $PEXELS_API_KEY = env('PEXELS_API_KEY');

            return Inertia::render(
                'Admin/Developer/StockMedia',
                compact(
                    'id',
                    'UNSPLASH_API_KEY',
                    'PEXELS_API_KEY',
                    'segments',
                    'buttons'
                )
            );
        }
        elseif ($id == 'custom-code') {
            $custom_header = file_exists(base_path('public/uploads/custom_header')) ? file_get_contents(base_path('public/uploads/custom_header')) : '';
            $custom_footer = file_exists(base_path('public/uploads/custom_footer')) ? file_get_contents(base_path('public/uploads/custom_footer')) : '';
            

            return Inertia::render(
                'Admin/Developer/CustomCode',
                compact(
                    'id',
                    'custom_header',
                    'custom_footer',
                    'segments',
                    'buttons'
                )
            );
        }

        abort(404);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
     
        if ($id == 'app-settings') {
            $this->editEnv('APP_NAME', Str::slug($request->APP_NAME));
            $this->editEnv('APP_DEBUG', filter_var($request->APP_DEBUG, FILTER_VALIDATE_BOOLEAN), true);
            $this->editEnv('WEB_VISIBILITY', filter_var($request->WEB_VISIBILITY ?? true, FILTER_VALIDATE_BOOLEAN), true);
            
            $this->editEnv('TIME_ZONE', $request->TIME_ZONE);
            $this->editEnv('DEFAULT_LANG', $request->DEFAULT_LANG ?? 'en');
        } elseif ($id == 'storage-settings') {
            $this->editEnv('FILESYSTEM_DISK', $request->FILESYSTEM_DISK);
            $this->editEnv('WAS_ACCESS_KEY_ID', $request->WAS_ACCESS_KEY_ID);
            $this->editEnv('SECRET_ACCESS_KEY', $request->SECRET_ACCESS_KEY);
            $this->editEnv('WAS_DEFAULT_REGION', $request->WAS_DEFAULT_REGION);
            $this->editEnv('WAS_BUCKET', $request->WAS_BUCKET);
            $this->editEnv('WAS_ENDPOINT', $request->WAS_ENDPOINT);
        } elseif ($id == 'newsletter-settings') {
            $this->editEnv('NEWSLETTER_API_KEY', $request->NEWSLETTER_API_KEY);
            $this->editEnv('NEWSLETTER_LIST_ID', $request->NEWSLETTER_LIST_ID);
          //  $this->editEnv('NEWSLETTER_ENDPOINT', $request->NEWSLETTER_ENDPOINT);
        } elseif ($id == 'mail-settings') {

            $this->editEnv('QUEUE_MAIL', filter_var($request->QUEUE_MAIL, FILTER_VALIDATE_BOOLEAN), true);
            $this->editEnv('MAIL_DRIVER_TYPE', $request->MAIL_DRIVER_TYPE);
            $this->editEnv($request->MAIL_DRIVER_TYPE, $request->MAIL_DRIVER);
            $this->editEnv('MAIL_HOST', $request->MAIL_HOST);
            $this->editEnv('MAIL_PORT', $request->MAIL_PORT);
            $this->editEnv('MAIL_USERNAME', $request->MAIL_USERNAME);
            $this->editEnv('MAIL_PASSWORD', $request->MAIL_PASSWORD);
            $this->editEnv('MAIL_ENCRYPTION', $request->MAIL_ENCRYPTION);
            $this->editEnv('MAIL_FROM_ADDRESS', $request->MAIL_FROM_ADDRESS);
            $this->editEnv('MAIL_FROM_NAME', $request->MAIL_FROM_NAME);
            $this->editEnv('MAIL_TO', $request->MAIL_TO);
        } elseif ($id == 'platform-settings') {

            $request->validate([
                'tiktok_verification_file' => ['nullable', 'file', 'mimes:txt'],
            ]);

            $this->editEnv('FACEBOOK_APP_ID', $request->FACEBOOK_APP_ID);
            $this->editEnv('FACEBOOK_APP_SECRET', $request->FACEBOOK_APP_SECRET);
            $this->editEnv('FACEBOOK_REDIRECT_URI', $request->FACEBOOK_REDIRECT_URI);

            $this->editEnv('INSTAGRAM_APP_ID', $request->INSTAGRAM_APP_ID);
            $this->editEnv('INSTAGRAM_APP_SECRET', $request->INSTAGRAM_APP_SECRET);

            $this->editEnv('TWITTER_API_KEY', $request->TWITTER_API_KEY);
            $this->editEnv('TWITTER_API_KEY_SECRET', $request->TWITTER_API_KEY_SECRET);
            $this->editEnv('TWITTER_ACCESS_TOKEN', $request->TWITTER_ACCESS_TOKEN);
            $this->editEnv('TWITTER_ACCESS_TOKEN_SECRET', $request->TWITTER_ACCESS_TOKEN_SECRET);
            $this->editEnv('TWITTER_CLIENT_ID', $request->TWITTER_CLIENT_ID);
            $this->editEnv('TWITTER_CLIENT_SECRET', $request->TWITTER_CLIENT_SECRET);

            $this->editEnv('LINKEDIN_APP_ID', $request->LINKEDIN_APP_ID);
            $this->editEnv('LINKEDIN_APP_SECRET', $request->LINKEDIN_APP_SECRET);

            $this->editEnv('TIKTOK_APP_ID', $request->TIKTOK_APP_ID);
            $this->editEnv('TIKTOK_APP_KEY', $request->TIKTOK_APP_KEY);
            $this->editEnv('TIKTOK_APP_SECRET', $request->TIKTOK_APP_SECRET);

            if ($request->hasFile('tiktok_verification_file')) {
                $file = $request->file('tiktok_verification_file');
                $file->move(public_path(), $file->getClientOriginalName());
            }
        } elseif ($id == 'ai-api-settings') {

            $this->editEnv('STABLE_DIFFUSION_API_MODE', $request->STABLE_DIFFUSION_API_MODE);
            $this->editEnv('STABLE_DIFFUSION_API_KEY', $request->STABLE_DIFFUSION_API_KEY);
            $this->editEnv('STABILITY_AI_API_KEY', $request->STABILITY_AI_API_KEY);
            $this->editEnv('OPENAI_API_KEY', $request->OPENAI_API_KEY);
            $this->editEnv('AI_MOCK_DATA', filter_var($request->AI_MOCK_DATA, FILTER_VALIDATE_BOOLEAN), true);
        } elseif ($id == 'cookie-settings') {
            $this->editEnv('COOKIE_CONSENT', $request->COOKIE_CONSENT, true);
            file_put_contents(database_path('json/cookie_data.json'), json_encode($request->cookieData));
        } elseif ($id == 'social-login-settings') {
            $this->editEnv('GOOGLE_CLIENT_ID', $request->GOOGLE_CLIENT_ID);
            $this->editEnv('GOOGLE_CLIENT_SECRET', $request->GOOGLE_CLIENT_SECRET);
            $this->editEnv('GOOGLE_REDIRECT_URL', $request->GOOGLE_REDIRECT_URL);

            $this->editEnv('FACEBOOK_CLIENT_ID', $request->FACEBOOK_APP_ID);
            $this->editEnv('FACEBOOK_CLIENT_SECRET', $request->FACEBOOK_APP_SECRET);
            $this->editEnv('FACEBOOK_REDIRECT_URI', $request->FACEBOOK_REDIRECT_URI);
        } elseif ($id == 'stock-media-settings') {
            $this->editEnv('UNSPLASH_API_KEY', $request->UNSPLASH_API_KEY);
            $this->editEnv('PEXELS_API_KEY', $request->PEXELS_API_KEY);
        }

        elseif ($id == 'custom-code') {
           File::put(base_path('public/uploads/custom_header'), $request->custom_header);
           File::put(base_path('public/uploads/custom_footer'), $request->custom_footer);
        }

        



        Toastr::success(__('Updated successfully'));

        return back();
    }
}
