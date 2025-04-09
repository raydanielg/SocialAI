<?php

return [

    'facebook' => [
        'app_id' => env('FACEBOOK_APP_ID'),
        'app_secret' => env('FACEBOOK_APP_SECRET'),
        'redirect_uri' => '/oauth/callback/facebook',

        'base_url' => 'https://www.facebook.com',
        'api_url' => 'https://graph.facebook.com',
        'api_version' => 'v18.0',

        'scopes' => [
            'pages_manage_posts',
            'pages_show_list',
            'pages_read_user_content',
            'pages_read_engagement',
            'read_insights'
        ],
        'requirements' => [
            'text' => [
                'limit' => 1000
            ],
            'images' => [
                'limit' => 10,
                'width' => 640,
                'height' => 640,
                'size' => 1024 // in kb
            ],
            'videos' => [
                'limit' => 10,
                'width' => 640,
                'height' => 640,
                'size' => 1024 // in kb
            ],
        ],
        'access_token_expire_at' => now()->addMonths(2),
    ],

    'instagram' => [
        'app_id' => env('INSTAGRAM_APP_ID'),
        'app_secret' => env('INSTAGRAM_APP_SECRET'),
        'base_url' => 'https://www.facebook.com',
        'api_url' => 'https://graph.facebook.com',
        'redirect_uri' => '/oauth/callback/instagram',
        'api_version' => 'v18.0',
        'scopes' => [
            'pages_manage_posts',
            'pages_show_list',
            'pages_read_user_content',
            'pages_read_engagement',
            'read_insights',

            'ads_management',
            'business_management',
            'instagram_basic',
            'instagram_content_publish',
        ],
        'requirements' => [
            'text' => [
                'limit' => 1000
            ],
            'images' => [
                'limit' => 10,
                'width' => 640,
                'height' => 640,
                'size' => 1024 // in kb
            ],
            'videos' => [
                'limit' => 10,
                'width' => 640,
                'height' => 640,
                'size' => 1024 // in kb
            ],
        ],
    ],

    'twitter' => [
        'app_id' => env('TWITTER_CLIENT_ID'),
        'client_secret' => env('TWITTER_CLIENT_SECRET'),

        'consumer_api_key' => env('TWITTER_API_KEY'),
        'consumer_api_secret' => env('TWITTER_API_KEY_SECRET'),
        'access_token' => env('TWITTER_ACCESS_TOKEN'),
        'access_token_secret' => env('TWITTER_ACCESS_TOKEN_SECRET'),

        'base_url' => 'https://twitter.com',
        'api_url' => 'https://api.x.com',
        'redirect_uri' => '/oauth/callback/twitter',
        'api_version' => '2',

        'options' => []
    ],

    'linkedin' => [
        'app_id' => env('LINKEDIN_APP_ID'),
        'app_secret' => env('LINKEDIN_APP_SECRET'),
        'base_url' => 'https://linkedin.com',
        'api_url' => 'https://api.linkedin.com',
        'redirect_uri' => '/oauth/callback/linkedin',
        'scopes' => ['openid profile email w_member_social'],
        // 'api_version' => 'v2',
        'header_version' => '202408',
        'restli_protocol_version' => '2.0.0',
        'options' => [
            'visibility' => 'PUBLIC',
            'feedDistribution' => 'MAIN_FEED'
        ]
    ],

    'tiktok' => [
        'app_id' => env('TIKTOK_APP_ID'),
        'app_key' => env('TIKTOK_APP_KEY'),
        'app_secret' => env('TIKTOK_APP_SECRET'),
        'redirect_uri' => env('APP_URL') . '/oauth/callback/tiktok',

        'base_url' => 'https://tiktok.com',
        'api_url' => 'https://open.tiktokapis.com',
        'api_version' => 'v2',

        'scope' => [
            'user.info.basic',
            'user.info.profile',
            'user.info.stats',
            'video.list',
            'video.publish',
            'video.upload',
        ],

        'options' => [
            'privacy_level' => 'SELF_ONLY',
            'disable_comment' => false,
            'disable_duet' => false,
            'disable_stitch' => false,
            'video_cover_timestamp_ms' => 1000,
            'auto_add_music' => true,
        ]
    ],

];
