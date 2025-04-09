<?php

return [
    'provider' => 'runwayml',
    'mock_enabled' => env('AI_MOCK_DATA', false),
    'api_key' => env('RUNWAYML_API_KEY'),

    'v1' => [
        'api_url' => 'https://api.dev.runwayml.com/v1',

        'models' => [
            'gen3a_turbo'
        ],

        'gen3a_turbo' => [
            'validation' => [
                'image' => 'required',
                'duration' => ['5', '10'],
                'ratio' => ['1280:768', '768:1280'],
            ]
        ]
    ],
];
