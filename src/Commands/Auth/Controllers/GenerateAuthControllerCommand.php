<?php

namespace Javaabu\Generators\Commands\Auth\Controllers;

use Javaabu\Generators\Commands\Auth\BaseAuthGenerateCommand;
use Javaabu\Generators\Generators\Auth\Controllers\AuthControllerGenerator;
use Javaabu\Generators\Generators\Auth\Controllers\BaseAuthControllerGenerator;

class GenerateAuthControllerCommand extends BaseAuthGenerateCommand
{

    protected $name = 'generate:auth_controller';

    protected $description = 'Generate auth model controller based on your database table schema';

    protected string $generator_class = AuthControllerGenerator::class;

    protected function createOutput(string $table, array $columns, string $auth_name): void
    {
        /** @var BaseAuthControllerGenerator $generator */
        $generator = $this->getGenerator($table, $columns, $auth_name);
        $output = $generator->render();
        $controller = $generator->getControllerName();

        if (app()->runningInConsole()) {
            $this->info("Schema-based auth $controller for table \"$table\" have been generated!");
            $this->info('Copy & paste these to your controller class:');
        }

        $this->line($output);
    }

    protected function createFiles(string $table, array $columns, string $auth_name, bool $force = false, string $path = ''): void
    {
        /** @var BaseAuthControllerGenerator $generator */
        $generator = $this->getGenerator($table, $columns, $auth_name);

        $path = $this->getPath(app_path($generator->getControllerPath()), $path);

        $file_name = $generator->getControllerName() . '.php';
        $file_path = $this->getFullFilePath($path, $file_name);

        $output = $generator->render();

        if ($this->putContent($file_path, $output, $force)) {
            $this->info("$file_name created!");
        }
    }
}
