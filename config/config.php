<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Whether tinyint1 should be considered as bool
    |--------------------------------------------------------------------------
    |
    */

    'tinyint1_to_bool' => env('GENERATORS_TINYINT1_TO_BOOL', true),


    /*
    |--------------------------------------------------------------------------
    | Which columns to always skip
    |--------------------------------------------------------------------------
    |
    */
    'skip_columns' => ['created_at', 'updated_at', 'deleted_at'],

    /*
    |--------------------------------------------------------------------------
    | Which columns to always skip for auth
    |--------------------------------------------------------------------------
    |
    */
    'auth_skip_columns' => [
        'name',
        'email',
        'email_verified_at',
        'password',
        'remember_token',
        'last_login_at',
        'login_attempts',
        'require_password_update',
        'status',
        'new_email'
    ],

    /*
    |--------------------------------------------------------------------------
    | Which icon provider to use
    |--------------------------------------------------------------------------
    |
    */
    'icon_provider' => \Javaabu\Generators\IconProviders\MaterialDesignIconicProvider::class,

    /*
    |--------------------------------------------------------------------------
    | Icon prefix to use for sidebar menu items
    |--------------------------------------------------------------------------
    |
    */
    'sidebar_icon_prefix' => 'zmdi-',
];
