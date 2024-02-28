<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;
use Javaabu\Activitylog\CauserTypes;
use Javaabu\Activitylog\SubjectTypes;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Relation::enforceMorphMap([
            'product' => \App\Models\Product::class,
            'category' => \App\Models\Category::class,
            'user' => \App\Models\User::class,
            'oauth_client' => \Laravel\Passport\Client::class,
            'role' => \Javaabu\Permissions\Models\Role::class,
        ]);

        SubjectTypes::register([
            \App\Models\Product::class,
            \App\Models\Category::class,
            \App\Models\User::class,
            \Javaabu\Permissions\Models\Role::class,
        ]);

        CauserTypes::register([
            \App\Models\User::class,
        ]);
    }
}
