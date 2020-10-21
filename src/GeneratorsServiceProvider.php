<?php

namespace Javaabu\Generators;

use Illuminate\Support\ServiceProvider;

class GeneratorsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerInstallCommand();
        $this->registerGeneratorsPolicyInstallCommand();
        $this->registerGeneratorsModelInstallCommand();
        $this->registerGeneratorsRequestInstallCommand();
        $this->registerGeneratorsControllerInstallCommand();
        $this->registerGeneratorsViewsInstallCommand();
        $this->registerGeneratorsRoutesInstallCommand();
        $this->registerGeneratorsTestInstallCommand();
    }

    /**
     * Register the adminlte:install command.
     */
    private function registerInstallCommand()
    {
        $this->app->singleton('command.dash8x.generators.install', function ($app) {
            return $app['Dash8x\Generators\Commands\GeneratorsInstallCommand'];
        });

        $this->commands('command.dash8x.generators.install');
    }

    /**
     * Register the routes:install command.
     */
    private function registerGeneratorsRoutesInstallCommand()
    {
        $this->app->singleton('command.dash8x.generators.routes', function ($app) {
            return $app['Dash8x\Generators\Commands\GeneratorsRoutesInstallCommand'];
        });

        $this->commands('command.dash8x.generators.routes');
    }
    
    /**
     * Register the policy:install command.
     */
    private function registerGeneratorsPolicyInstallCommand()
    {
        $this->app->singleton('command.dash8x.generators.policy', function ($app) {
            return $app['Dash8x\Generators\Commands\GeneratorsPolicyInstallCommand'];
        });

        $this->commands('command.dash8x.generators.policy');
    }

    /**
     * Register the model:install command.
     */
    private function registerGeneratorsModelInstallCommand()
    {
        $this->app->singleton('command.dash8x.generators.model', function ($app) {
            return $app['Dash8x\Generators\Commands\GeneratorsModelInstallCommand'];
        });

        $this->commands('command.dash8x.generators.model');
    }

    /**
     * Register the request:install command.
     */
    private function registerGeneratorsRequestInstallCommand()
    {
        $this->app->singleton('command.dash8x.generators.request', function ($app) {
            return $app['Dash8x\Generators\Commands\GeneratorsRequestInstallCommand'];
        });

        $this->commands('command.dash8x.generators.request');
    }
    
    /**
     * Register the controller:install command.
     */
    private function registerGeneratorsControllerInstallCommand()
    {
        $this->app->singleton('command.dash8x.generators.controller', function ($app) {
            return $app['Dash8x\Generators\Commands\GeneratorsControllerInstallCommand'];
        });

        $this->commands('command.dash8x.generators.controller');
    }

    /**
     * Register the view:install command.
     */
    private function registerGeneratorsViewsInstallCommand()
    {
        $this->app->singleton('command.dash8x.generators.views', function ($app) {
            return $app['Dash8x\Generators\Commands\GeneratorsViewsInstallCommand'];
        });

        $this->commands('command.dash8x.generators.views');
    }

    /**
     * Register the test:install command.
     */
    private function registerGeneratorsTestInstallCommand()
    {
        $this->app->singleton('command.dash8x.generators.tests', function ($app) {
            return $app['Dash8x\Generators\Commands\GeneratorsTestsInstallCommand'];
        });

        $this->commands('command.dash8x.generators.tests');
    }

}
