<?php

return [
    'enable' => true,

    'routes' => [
        'docs' => 'api/documentation',
        'oauth2_callback' => 'api/oauth2-callback',
        'middleware' => [
            'api' => [],
            'asset' => [],
            'docs' => [],
            'oauth2_callback' => [],
        ],
    ],

    'paths' => [
        'docs_json' => storage_path('api-docs/api-docs.json'),
        'annotations' => [
            base_path('app'),
        ],
        'views' => base_path('resources/views/vendor/l5-swagger'),
    ],

    'generate_always' => env('L5_SWAGGER_GENERATE_ALWAYS', false),
];
