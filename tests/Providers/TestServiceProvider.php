<?php

namespace Javaabu\Generators\Tests\Providers;

use Illuminate\Support\ServiceProvider;
use Javaabu\Generators\Commands\Auth\GenerateAuthFactoryCommand;
use Javaabu\Generators\Commands\Auth\GenerateAuthPasswordResetsCommand;
use Javaabu\Generators\Commands\GenerateAllCommand;
use Javaabu\Generators\Commands\GenerateApiCommand;
use Javaabu\Generators\Commands\GenerateApiControllerCommand;
use Javaabu\Generators\Commands\GenerateApiTestCommand;
use Javaabu\Generators\Commands\GenerateControllerCommand;
use Javaabu\Generators\Commands\GenerateExportCommand;
use Javaabu\Generators\Commands\GenerateFactoryCommand;
use Javaabu\Generators\Commands\GenerateModelCommand;
use Javaabu\Generators\Commands\GeneratePermissionsCommand;
use Javaabu\Generators\Commands\GeneratePolicyCommand;
use Javaabu\Generators\Commands\GenerateRequestCommand;
use Javaabu\Generators\Commands\GenerateRollbackCommand;
use Javaabu\Generators\Commands\GenerateRoutesCommand;
use Javaabu\Generators\Commands\GenerateTestCommand;
use Javaabu\Generators\Commands\GenerateViewsCommand;
use Javaabu\Generators\Contracts\SchemaResolverInterface;
use Javaabu\Generators\Exceptions\UnsupportedDbDriverException;
use Javaabu\Generators\Resolvers\SchemaResolverMySql;

class TestServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database');
    }

    /**
     * Register the application services.
     */
    public function register()
    {

    }
}
