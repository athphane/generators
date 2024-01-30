<?php

namespace Javaabu\Generators;

use Illuminate\Support\ServiceProvider;
use Javaabu\Generators\Resolvers\BaseResolver;
use Javaabu\Generators\Resolvers\FactoryResolver;
use LaracraftTech\LaravelSchemaRules\Contracts\SchemaRulesResolverInterface;

class GeneratorsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        // declare publishes
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/config.php' => config_path('generators.php'),
            ], 'generators-config');
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // merge package config with user defined config
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'generators');
    }
}
