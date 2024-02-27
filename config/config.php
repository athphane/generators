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
    | Which icon provider to use
    |--------------------------------------------------------------------------
    |
    */
    'icon_provider' => \Javaabu\Generators\IconProviders\MaterialDesignIconicProvider::class,
];
