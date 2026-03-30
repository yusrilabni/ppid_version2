<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Login Protection Settings
    |--------------------------------------------------------------------------
    |
    | Konfigurasi untuk sistem proteksi login yang memerlukan password
    | untuk akses ke sistem login dan pengelolaan akun penting
    |
    */

    'enabled' => env('LOGIN_PROTECTION_ENABLED', true),

    'protection_password' => env('LOGIN_PROTECTION_PASSWORD', 'default_protection_password'),

    'protected_paths' => [
        'app/Http/Controllers/Auth/*',
        'app/Models/User.php',
        'config/ppid.php',
    ],

    'admin_verification_required' => [
        'routes' => [
            'admin.*',
            'auth.*',
        ],
        'actions' => [
            'edit_user',
            'change_password',
            'sync_api_data',
            'modify_roles',
        ],
    ],

    'session_timeout' => 30, // Minutes
];