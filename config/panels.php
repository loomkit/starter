<?php

return [
    'default' => env('PANEL_ID', 'app'),

    'app' => [
        'guard' => env('AUTH_GUARD', 'web'),
        'id' => env('PANEL_ID', 'app'),
        'path' => env('PANEL_PATH', 'app'),
    ],

    'admin' => [
        'guard' => env('ADMIN_AUTH_GUARD', 'admin'),
        'id' => env('ADMIN_PANEL_ID', 'admin'),
        'path' => env('ADMIN_PANEL_PATH', 'admin'),
    ],
];
