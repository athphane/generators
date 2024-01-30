<?php

namespace Javaabu\Generators;

use Illuminate\Support\ServiceProvider;
use Javaabu\Generators\Contracts\SchemaResolverInterface;
use Javaabu\Generators\Exceptions\UnsupportedDbDriverException;
use Javaabu\Generators\Resolvers\SchemaResolverMySql;

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

        $this->app->bind(SchemaResolverInterface::class, function ($app, $parameters) {
            $connection = config('database.default');
            $driver = config("database.connections.{$connection}.driver");

            switch ($driver) {
                case 'mysql': $class = SchemaResolverMySql::class;
                    break;

                default: throw new UnsupportedDbDriverException('This db driver is not supported: '.$driver);
            }

            return new $class(...array_values($parameters));
        });
    }
}
