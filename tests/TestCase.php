<?php

namespace Javaabu\Generators\Tests;

use Illuminate\Filesystem\Filesystem;
use Javaabu\Generators\Tests\Providers\TestServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;
use Javaabu\Generators\GeneratorsServiceProvider;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
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
            GeneratorsServiceProvider::class,
            TestServiceProvider::class
        ];
    }

    protected function getTestStubContents(string $stub): string
    {
        return file_get_contents($this->getTestStubPath($stub));
    }

    protected function getGeneratedFileContents(string $file): string
    {
        return file_get_contents($file);
    }

    protected function getTestStubPath(string $name): string
    {
        return __DIR__ . '/stubs/' . $name;
    }

    protected function makeDirectory(string $path)
    {
        /** @var Filesystem $files */
        $files = $this->app->make(Filesystem::class);

        if (! $files->isDirectory(dirname($path))) {
            $files->makeDirectory(dirname($path), 0777, true, true);
        }
    }

    /**
     * Clear directory
     */
    protected function deleteDirectory(string $path)
    {
        /** @var Filesystem $files */
        $files = $this->app->make(Filesystem::class);
        $files->deleteDirectory($path);
    }

    /**
     * Delete files
     */
    protected function deleteFile(string $path)
    {
        /** @var Filesystem $files */
        $files = $this->app->make(Filesystem::class);
        $files->delete($path);
    }

    /**
     * Clear directory
     */
    protected function copyFile(string $from, string $to)
    {
        /** @var Filesystem $files */
        $files = $this->app->make(Filesystem::class);
        $files->copy($from, $to);
    }
}
