<?php

    return [
        'enabled' => env('REQUEST_CATCHER_ENABLED', false),
        'vendor'    => [
            'migrations_path' => 'database/migrations/'
        ],
        'interface' => [
            'per_page' => 50,
        ],
        'log'       => [
            'allow_error_codes' => [
//                200,
//                403,
//                404,
//                500
            ],
            'blocked_routes'    => [
                'request-catcher.requests.index',
                'request-catcher.requests.resend',
                'request-catcher.requests.show',
                'request-catcher.requests.delete-all',
            ],
            'disable_urls'        => [
//                'request-catcher/test'
            ]
        ]
    ];