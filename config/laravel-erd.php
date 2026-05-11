<?php

return [

    /*
    |--------------------------------------------------------------------------
    | URI
    |--------------------------------------------------------------------------
    |
    | The URI where the ERD will be available.
    |
    */

    'uri' => 'erd',

    /*
    |--------------------------------------------------------------------------
    | Middleware
    |--------------------------------------------------------------------------
    |
    | The middleware that will be applied to the ERD route.
    |
    */

    'middleware' => ['web'],

    /*
    |--------------------------------------------------------------------------
    | Models Path
    |--------------------------------------------------------------------------
    |
    | The path where your models are located.
    |
    */

    'models_path' => app_path('Models'),

    /*
    |--------------------------------------------------------------------------
    | Ignore Tables
    |--------------------------------------------------------------------------
    |
    | The tables that should be ignored when generating the ERD.
    |
    */

    'ignore_tables' => [
        'migrations',
        'failed_jobs',
        'password_reset_tokens',
        'personal_access_tokens',
        'sessions',
    ],

];
