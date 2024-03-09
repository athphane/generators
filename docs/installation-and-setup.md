---
title: Installation & Setup
sidebar_position: 1.2
---

You can install the package via composer:

```bash
composer require javaabu/generators
```

# Publishing the config file

Publishing the config file is optional:

```bash
php artisan vendor:publish --provider="Javaabu\Generators\GeneratorsServiceProvider" --tag="generators-config"
```

This is the default content of the config file:

```php
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

    /*
    |--------------------------------------------------------------------------
    | Icon prefix to use for sidebar menu items
    |--------------------------------------------------------------------------
    |
    */
    'sidebar_icon_prefix' => 'zmdi-',
];

```
