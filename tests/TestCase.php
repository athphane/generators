<?php

namespace Javaabu\Generators\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;
use Javaabu\Generators\GeneratorsServiceProvider;

abstract class TestCase extends BaseTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->app['config']->set('app.key', 'base64:yWa/ByhLC/GUvfToOuaPD7zDwB64qkc/QkaQOrT5IpE=');

        $this->app['config']->set('session.serialization', 'php');

        $this->app['config']->set('database.default', 'mysql');

        $this->app['config']->set('database.connections.mysql', [
            'driver'   => 'mysql',
            'database' => env('DB_DATABASE'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'username' => env('DB_USERNAME'),
            'password' => env('DB_PASSWORD', ''),
            'prefix'   => '',
        ]);

    }

    protected function getPackageProviders($app)
    {
        return [
            GeneratorsServiceProvider::class
        ];
    }

    protected function getStubContents(string $stub): string
    {
        return file_get_contents($this->getStubPath($stub));
    }

    protected function getStubPath(string $name): string
    {
        return __DIR__ . '/stubs/' . $name;
    }
}
