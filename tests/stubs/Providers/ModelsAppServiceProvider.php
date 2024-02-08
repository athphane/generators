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
        Relation::morphMap([
            'product' => \App\Models\Product::class,
            'category' => \App\Models\Category::class,
        ]);

        SubjectTypes::register([
            \App\Models\Product::class,
            \App\Models\Category::class,
        ]);

        CauserTypes::register([
        ]);
    }
}
